<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Http\Requests\StoreBranchRequest;
use Illuminate\Database\QueryException;
use App\Http\Requests\UpdateBranchRequest;
use App\Models\User;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("entities.branches.index", [
            "list" => Branch::withCount("products")->withCount("users")->withCount("employees")->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("entities.branches.createOrEdit",[
            "users" => User::all(['id', 'name'])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBranchRequest $request)
    {
        $safe = $request->safe()->toArray();
        return Branch::storeModel($safe, "Branch created", "branches.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        return view("entities.branches.createOrEdit", [
            "users" => User::all(['id', 'name']),
            "branch" => $branch
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBranchRequest $request, Branch $branch)
    {
        $safe = $request->safe()->toArray();
        try {
            $branch->updateOrFail($safe);
            return redirect()->route("branches.index")->with("success", $branch->name . " branch updated.");
        } catch (QueryException $e) {
            return back()->withErrors([
                "error" => "Can't update record with that value!"
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        try {
            $branch->deleteOrFail();
            return response(["success" => "Branch deleted"]);
        } catch (QueryException $e) {
            return response([
                "error" => "This record can't deleted!",
                "sql" => $e->getMessage()
            ], 400);
        }
    }
}
