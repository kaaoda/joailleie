<?php

namespace App\Http\Controllers;

use App\Models\Diamond;
use App\Http\Requests\StoreDiamondRequest;
use App\Http\Requests\UpdateDiamondRequest;

class DiamondController extends Controller
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
    public function store(StoreDiamondRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Diamond $diamond)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Diamond $diamond)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDiamondRequest $request, Diamond $diamond)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Diamond $diamond)
    {
        //
    }
}
