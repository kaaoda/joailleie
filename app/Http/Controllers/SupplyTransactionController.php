<?php

namespace App\Http\Controllers;

use App\Models\SupplyTransaction;
use App\Http\Requests\StoreSupplyTransactionRequest;
use App\Http\Requests\UpdateSupplyTransactionRequest;
use App\Models\ProductDivision;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class SupplyTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplyTransactionRequest $request)
    {
        $safe = $request->safe()->toArray();

        if ($safe['product_division_id'] == 1) $safe['transaction_scope'] = 'PRODUCTS';

        if ($safe['transaction_scope'] == 'GOLD') $safe['products_number'] = 0;

        try {
            $response = DB::transaction(function() use ($safe){
                //Supplier::find($safe['supplier_id'])->decrement("balance", $safe['paid_amount']);
                return SupplyTransaction::storeModel($safe, "Transaction created", "suppliers.show", ['supplier' => $safe['supplier_id']]);
            });
        } catch (\Throwable $th) {
            //throw $th;
        }

        
    }

    /**
     * Display the specified resource.
     */
    public function show(SupplyTransaction $supplyTransaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SupplyTransaction $supplyTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplyTransactionRequest $request, SupplyTransaction $supplyTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SupplyTransaction $supplyTransaction)
    {
        //
    }
}
