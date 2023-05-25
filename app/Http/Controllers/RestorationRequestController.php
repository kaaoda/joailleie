<?php

namespace App\Http\Controllers;

use App\Models\RestorationRequest;
use App\Http\Requests\StoreRestorationRequestRequest;
use App\Http\Requests\UpdateRestorationRequestRequest;
use App\Models\Customer;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class RestorationRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("entities.restorations.index", [
            "list" => RestorationRequest::with('customer')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("entities.restorations.createOrEdit", [
            'customers' => Customer::all(['id', 'full_name'])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRestorationRequestRequest $request)
    {
        $safe = $request->safe()->toArray();
        if($request->hasFile('pic')) $safe['picture_path'] = $request->file('pic')->store("restorations");
        $safe['request_number'] = rand(1,9999999);
        return RestorationRequest::storeModel($safe, "Request created", "restorations.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(RestorationRequest $restoration)
    {
        $restoration->load(['customer', 'transactions']);
        return view('entities.restorations.show', [
            'restoration' => $restoration
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RestorationRequest $restoration)
    {
        return view("entities.restorations.createOrEdit", [
            'customers' => Customer::all(['id', 'full_name']),
            'restoration' => $restoration
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRestorationRequestRequest $request, RestorationRequest $restoration)
    {
        $safe = $request->safe()->toArray();

        $safe = array_filter($safe, fn($val) => $val != "" || $val != NULL);

        if(isset($safe['status']) && !$restoration->status) 
        {
            $safe['status'] = $safe['status'] == 'on' ? TRUE : FALSE;
        }
        return $restoration->update($safe) 
        ? redirect()->route('restorations.index')->with('success', "Updated!")
        : back()->withErrors([
            'error' => "Update not saved due to some errors"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RestorationRequest $restoration)
    {
        try {
            $restoration->deleteOrFail();
            if($restoration->picture_path) Storage::delete($restoration->picture_path);
            return response(["success" => "Record deleted"]);
        } catch (QueryException $e) {
            return response([
                "error" => "This record can't deleted!",
                "sql" => $e->getMessage()
            ], 400);
        }
    }
}
