<?php

namespace App\Http\Controllers;

use App\Models\Due;
use App\Http\Requests\StoreDueRequest;
use App\Http\Requests\UpdateDueRequest;
use App\Models\Invoice;
use Illuminate\Support\Facades\Gate;

class DueController extends Controller
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
    public function store(StoreDueRequest $request)
    {
        $safe = $request->safe()->toArray();
        if(Gate::denies("isManager") && $safe['dueable_type'] != Invoice::class)
        {
            abort(403, "An access attempt was not allowed, the attempt was recorded and sent to the administrator!");
        }
        return Due::storeModel($safe, "Payment Added!", back:TRUE);
    }

    /**
     * Display the specified resource.
     */
    public function show(Due $due)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Due $due)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDueRequest $request, Due $due)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Due $due)
    {
        //
    }
}
