<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Http\Requests\StoreProductCategoryRequest;
use App\Http\Requests\UpdateProductCategoryRequest;
use Illuminate\Database\QueryException;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("entities.productCategories.index", [
            "list" => ProductCategory::with("division:id,name")->withCount("products")->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("entities.productCategories.createOrEdit");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductCategoryRequest $request)
    {
        $safe = $request->safe()->toArray();
        return ProductCategory::storeModel($safe, "Category created", "product_categories.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductCategoryRequest $request, ProductCategory $productCategory)
    {
        $safe = $request->safe()->toArray();
        try {
            $productCategory->updateOrFail($safe);
            return redirect()->route("product_categories.index")->with("success", $productCategory->name . " category updated.");
        } catch (QueryException $e) {
            return back()->withErrors([
                "error" => "Can't update record with that value!"
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $productCategory)
    {
        try {
            $productCategory->deleteOrFail();
            return response(["success" => "Category deleted"]);
        } catch (QueryException $e) {
            return response([
                "error" => "This record can't deleted!",
                "sql" => $e->getMessage()
            ], 400);
        }
    }
}
