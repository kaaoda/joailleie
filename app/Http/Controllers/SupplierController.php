<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Currency;
use App\Models\ProductDivision;

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
            "divisions" => ProductDivision::all()
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
        //
    }
}
