<?php

namespace App\Http\Controllers;

use App\Models\OrderReturn;
use App\Http\Requests\StoreOrderReturnRequest;
use App\Http\Requests\UpdateOrderReturnRequest;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;
use Illuminate\Support\Str;

class OrderReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('entities.returns.index',[
            "list" => OrderReturn::with(['order', 'order.customer', 'order.branch'])->paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if(!$request->has('order') || !$request->query('order')) abort(403);
        return view('entities.returns.create', [
            'order' => Order::with('products')->findOrFail($request->query('order'))
        ]);
    }

    private static function getDetailedOrderInfoFromRequest(Request $request, $originalOrder)
    {
        $safe = $request->safe();

        $safeData = new stdClass();

        $safeData->goldPrice = $safe->goldPrice;

        //get detailed products
        foreach ($safe->products as $product_id) :
            $safeData->products[] = (object)[
                "id" => $product_id,
                "sale_manufacturing_value" => $safe->prices[$product_id] ?? $originalOrder->products->firstWhere('id', $product_id)->pivot->sale_manufacturing_value,
                "gram_price" => $safe-> goldPrice ?? $originalOrder->products->firstWhere('id', $product_id)->pivot->gram_price
            ];
        endforeach;

        return $safeData;
    }

    private static function createOrderReturn($safeData,Order $order)
    {
        return OrderReturn::create([
            "order_number" => 'EXC-' . Str::random(3) . '-' . Carbon::now()->format('YmdHis'),
            "order_id" => $order->id,
            "type" => "EXCHANGE",
            "total" => 0,
            "diff_amount" => 0,
            "total_weight" => 0
        ]);
    }

    private static function attachProductsToOrder($safeData, OrderReturn $orderReturn, Order $order)
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
                "gram_price" => $safeData->goldPrice,
                "sale_manufacturing_value" => $product->sale_manufacturing_value,
                "created_at" => now(),
                "updated_at" => now()
            ];
            $totalProductsPrice += $productPrice;
        endforeach;
        $orderReturn->products()->attach($products);
        $orderReturn->update([
            "total"=> $totalProductsPrice,
            "diff_amount" => $totalProductsPrice - $order->total,
            "total_weight" => $orderReturn->products->sum('weight')
        ]);
        return $orderReturn;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderReturnRequest $request)
    {
        $safeData = $request->safe()->toArray();
        $order = Order::find($safeData['order_id']);
        //dd(self::getDetailedOrderInfoFromRequest($request, $order));
        switch($safeData['type'])
        {
            case 'RETURN':
                return OrderReturn::storeModel(
                    [...$safeData, 'total' => -$order->total, 'diff_amount' => -$order->total, 'total_weight' => 0], 
                    "Order Refunded!", 
                    "orders.show", 
                    ['order' => $order->id]
                );

            case 'EXCHANGE':
                //check role
                //self::checkStorePermission($request);

                //get data from request
                $safeData = self::getDetailedOrderInfoFromRequest($request, $order);
                //dd($safeData);
                try {
                    $orderReturn = DB::transaction(function () use ($safeData, $order) {
                        $orderReturn = self::createOrderReturn($safeData, $order);
                        $orderReturn = self::attachProductsToOrder($safeData, $orderReturn, $order);
                        if($orderReturn->diff_amount < 0) $order->customer()->increment("balance", abs($orderReturn->diff_amount));
                        return $orderReturn;
                    });
                    return redirect()->route("returns.show", ['return' => $orderReturn->id])->with("success", "Order #" . $order->order_number . " Returned, make invoice!");
                } catch (Exception $e) {
                    return back()->withErrors([
                        "error" => $e->getMessage()
                    ]);
                }
                break;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderReturn $orderReturn)
    {
        $orderReturn->load(['order', 'order.customer', 'products']);
        return view('entities.returns.show', compact('orderReturn'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderReturn $orderReturn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderReturnRequest $request, OrderReturn $orderReturn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderReturn $orderReturn)
    {
        //
    }
}
