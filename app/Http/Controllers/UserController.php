<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = User::with('role')->get();
        return view("entities.users.index", compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("entities.users.createOrEdit");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $safe = $request->validate([
            "name" => "required|string",
            "username" => "required|string|unique:users",
            "password" => "required",
            "branch_id" => "required|numeric|exists:branches,id",
            "role_id" => "required|numeric|exists:roles,id",
        ]);
        $safe['email'] = fake()->email();
        return User::storeModel($safe, "User Created", "users.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view("entities.users.show", compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view("entities.users.createOrEdit", compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $safe = $request->validate([
            "name" => "nullable|string",
            "username" => "nullable|string|unique:users",
            "password" => "nullable",
            "branch_id" => "nullable|numeric|exists:branches,id",
            "role_id" => "nullable|numeric|exists:roles,id",
        ]);
        
        $safe = array_filter($safe, fn($val) => $val != "" || $val != NULL);
        
        return $user->update($safe) ? back()->with(['success' => 'Data Updated']) : back()->withErrors(['error', 'Not Saved due to errors!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->deleteOrFail();
            return response(["success" => "Branch deleted"]);
        } catch (QueryException $e) {
            return response([
                "error" => "This record can't deleted!",
                "sql" => $e->getMessage()
            ], 400);
        }
    }
}
