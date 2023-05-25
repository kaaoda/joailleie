<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Currency;
use App\Models\ProductDivision;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("entities.suppliers.index", [
            "list" => Supplier::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("entities.suppliers.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request)
    {
        $safe = $request->safe()->toArray();
        if (Supplier::create($safe))
            return redirect()->route("suppliers.index")->with("success", "Supplier created successfully");
        else
            return back()->withErrors([
                "error" => "Something wrong happen, try again or contact tech support"
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        return view("entities.suppliers.show", [
            "supplier" => $supplier->loadCount("transactions")->loadSum("transactions", "ore_weight_in_grams"),
            "transactions" => $supplier->transactions()->with("division")->paginate(5),
            "currencies" => Currency::all(),
            "divisions" => ProductDivision::all(),
            "goldIn" => $supplier->products()->sum('weight'),
            "goldOut" => $totalWeight = DB::table('suppliers')
                ->join('products', 'suppliers.id', '=', 'products.supplier_id')
                ->join('order_product', 'products.id', '=', 'order_product.product_id')
                ->join('orders', 'order_product.order_id', '=', 'orders.id')
                ->where('suppliers.id', $supplier->id)
                ->sum('products.weight')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        try {
            $supplier->deleteOrFail();
            return response(["success" => "Supplier deleted"]);
        } catch (QueryException $e) {
            return response([
                "error" => "This record can't deleted!",
                "sql" => $e->getMessage()
            ], 400);
        }
    }
}
