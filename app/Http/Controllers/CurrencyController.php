<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Http\Requests\StoreCurrencyRequest;
use App\Http\Requests\UpdateCurrencyRequest;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("entities.currencies.index", [
            "list" => Currency::all()
        ]);
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
    public function store(StoreCurrencyRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Currency $currency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Currency $currency)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCurrencyRequest $request, Currency $currency)
    {
        $safe = $request->safe()->toArray();
        if($currency->main && isset($safe['exchange_rate'])) return response(["error" => "Main currency doesn't have exchange rate"], 400);
        if(isset($safe['main'])) Currency::query()->update([
            "main" => FALSE,
            "exchange_rate" => NULL
        ]);
        return $currency->update($safe) ? response(["success" => "Currency Updated"]) : response(["error" => "Something wrong happen!"], 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Currency $currency)
    {
        //
    }
}
