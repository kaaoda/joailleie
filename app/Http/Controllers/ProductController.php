<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Branch;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Diamond;
use App\Models\ProductCategory;
use App\Models\Supplier;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Milon\Barcode\DNS1D;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::with(["category:id,name", "branch:id,name"]);
        if ($request->has("search"))
            $products->where("barcode", "LIKE", "%" . $request->query("search") . "%");
        if ($request->has("branch"))
            $products->where("branch_id", "=", $request->query("branch"));
        return view("entities.products.index", [
            "list" => $products->paginate(8),
            "branches" => Branch::withCount("products")->get()
        ]);
    }

    public function searchByBarcodeWithAjax(Request $request)
    {
        if ($request->expectsJson()) {
            $safe = $request->validate([
                "barcode" => ["required"]
            ]);

            return Product::where("barcode", $safe['barcode'])->with(['category', 'category.division'])->firstOrFail();
        }
        abort(403);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("entities.products.createOrEdit", [
            "suppliers" => Supplier::all(["id", "name"]),
            "branches" => Branch::all(["id", "name"]),
            "categories" => ProductCategory::with("division:id,name")->get(["id", "name", "product_division_id"])->groupBy("division.name"),
            "currencies" => Currency::all()
        ]);
    }

    private static function sotreProductWithDiamonds($productData, $diamondsData)
    {
        $product = Product::create($productData);
        $diamonds = [];
        foreach ($diamondsData as $diamond) {
            $diamond = (object)$diamond;
            array_push($diamonds, new Diamond([
                "number_of_stones" => $diamond->number_of_stones,
                "weight" => $diamond->weight,
                "clarity" => $diamond->diamondClarity,
                "color" => $diamond->color,
                "shape" => $diamond->diamondShape,
                "price" => $diamond->price,
                "currency_id" => $productData['currency_id'],
                "exchange_rate" => Currency::findOrFail($productData['currency_id'])->exchange_rate
            ]));
        }
        $product->diamonds()->saveMany($diamonds);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        //get data from request
        $safe = $request->safe();
        $img = $request->hasFile("image") ? $request->file("image") : NULL;

        //check if category gold or diamond
        $division = ProductCategory::find($safe->category_id)->division->name;

        //base data for all divisions
        $data = [
            "product_category_id" => $safe->category_id,
            "branch_id" => $safe->branch_id,
            "supplier_id" => $safe->supplier_id,
            "weight" => $safe->goldWeight,
            "thumbnail_path" => $img !== NULL ? $img->store("images/products") : NULL,
            "barcode" => $safe->barcode,
            "kerat" => $safe->kerat,
            "cost" => $safe->cost ?? 0,
            "manufacturing_value" => $safe->manufacturing_value,
            "lowest_manufacturing_value_for_sale" => $safe->lowest_manufacturing_value_for_sale,
        ];

        switch (strtolower($division)) {
            case 'gold':
                return Product::storeModel($data, "Gold product created", "products.index");

            case 'diamond':
                try {
                    DB::transaction(function () use ($safe, $data) {
                        $RawDiamondsData = $safe->diamonds['diamonds'];
                        self::sotreProductWithDiamonds([...$data, "currency_id" => $safe['currency_id']], $RawDiamondsData);
                    });
                    return redirect()->route("products.index")->with("success", "Diamond product created");
                } catch (QueryException $e) {
                    return back()->withErrors([
                        "error" => $e->getMessage()//"Something wrong happen"
                    ]);
                }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $barcode = DNS1D::getBarcodeHTML($product->barcode, "C128",1.5,33);
        $customers_number = Customer::whereRelation("orders.products", "product_id", $product->id)->count();
        $product->load("category")
            ->load("branch")
            ->load("supplier")
            ->load("diamonds");
        return view("entities.products.show", compact('product', "barcode"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        return Product::deleteModel($product);
    }
}
