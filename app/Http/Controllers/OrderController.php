<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\OrderAdditionalService;
use App\Models\Product;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("entities.orders.index", [
            "list" => Order::with(["customer:id,full_name", "branch:id,name", "invoice"])->paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("entities.orders.create", [
            "customers" => Customer::all(["id", "full_name"]),
            "branches" => Branch::all(["id", "name"])
        ]);
    }

    private static function getDetailedOrderInfoFromRequest(Request $request)
    {
        $safe = $request->safe();

        $safeData = new stdClass();

        $safeData->customer_id = $safe->customer_id;
        $safeData->branch_id = $safe->branch_id;
        $safeData->goldPrice = $safe->goldPrice;

        $orderTotal = 0;

        //get detailed products
        foreach ($safe->products as $product_id) :
            $safeData->products[] = (object)[
                "id" => $product_id,
                "sale_manufacturing_value" => $safe->prices[$product_id],
                "quantity" => 1,
                "gram_price" => $safe->goldPrice
            ];
        endforeach;

        //get detailed additional services
        foreach ($safe->additional_services['additional_services'] as $service) :
            $safeData->additional_services[] = (object)[
                "description" => $service['servicesDesc'],
                "cost" => $service['servicesCost'],
            ];
        endforeach;

        return $safeData;
    }

    private static function createOrder($safeData)
    {
        return Order::create([
            "order_number" => 'ORD-' . Str::random(3) . '-' . Carbon::now()->format('YmdHis'),
            "customer_id" => $safeData->customer_id,
            "branch_id" => $safeData->branch_id,
            "date" => now(),
            "total" => 0
        ]);
    }

    private static function attachProductsToOrder($safeData, Order $order)
    {
        $products = [];
        $totalProductsPrice = 0;
        foreach ($safeData->products as $product) :
            $fetchedProduct = Product::find($product->id);
            $productPrice = strtolower($fetchedProduct->division->name) === "gold" 
            ? ($product->sale_manufacturing_value + $safeData->goldPrice) * $fetchedProduct->weight
            : $product->sale_manufacturing_value;
            $products[$product->id] = [
                "price" => $productPrice,
                "quantity" => $product->quantity,
                "gram_price" => $safeData->goldPrice,
                "sale_manufacturing_value" => $product->sale_manufacturing_value,
                "created_at" => now(),
                "updated_at" => now()
            ];
            $totalProductsPrice += $productPrice;
        endforeach;
        $order->products()->attach($products);
        $order->increment("total", $totalProductsPrice);
        return $order;
    }

    private static function attachAdditionalServicesToOrder($safeData, Order $order)
    {
        if (!$safeData->additional_services[0]->description) return $order;
        $services = [];
        $totalProductsPrice = 0;
        foreach ($safeData->additional_services as $service) :
            $services[] = new OrderAdditionalService([
                "description" => $service->description,
                "cost" => $service->cost,
            ]);
            $totalProductsPrice += $service->cost;
        endforeach;
        $order->additionalServices()->saveManyQuietly($services);
        $order->increment("total", $totalProductsPrice);
        return $order;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        //get data from request
        $safeData = self::getDetailedOrderInfoFromRequest($request);
        //dd($safeData);
        try {
            $order = DB::transaction(function () use ($safeData) {
                $order = self::createOrder($safeData);
                $order = self::attachProductsToOrder($safeData, $order);
                self::attachAdditionalServicesToOrder($safeData, $order);
                return $order;
            });
            return redirect()->route("orders.show", ['order' => $order->id])->with("success", "Order #" . $order->order_number . " created, add invoice to it");
        } catch (Exception $e) {
            return back()->withErrors([
                "error" => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load(["customer", "products", "additionalServices"]);
        return view("entities.orders.show", compact("order"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
