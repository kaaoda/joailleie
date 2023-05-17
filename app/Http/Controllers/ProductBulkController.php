<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Supplier;
use Exception;
use Illuminate\Http\Request;

class ProductBulkController extends Controller
{
    public function createGoldProducts()
    {
        return view("entities.bulk.products.createGold",[
            "suppliers" => Supplier::all(["id", "name"]),
            "categories" => ProductCategory::whereRelation("division", "name", "=", "GOLD")->with("division:id,name")->get(["id", "name", "product_division_id"])->groupBy("division.name")
        ]);
    }

    public function storeGoldProducts(Request $request)
    {

        $request->validate([
            'products.products' => 'required|array',
            'products.products.*' => 'required|array|size:5'
        ]);
        $products = $request->input()['products']['products'];
        $done = [];
        $failed = [];
        $branchHQ = Branch::where("name", "=", "HQ")->first()->id;
        $ptr = 1;
        foreach($products as $idiot => $product):
            try {
                if (array_search(NULL, array_values($product)) !== FALSE) throw new Exception();
                $createdModel = Product::create([
                    "product_category_id" => $product['category_id'],
                    "branch_id" => $branchHQ,
                    "supplier_id" => $product['supplier_id'],
                    "weight" => $product['weight'],
                    "thumbnail_path" => NULL,
                    "barcode" => NULL,
                    "kerat" => '18',
                    "cost" => 0,
                    "manufacturing_value" => $product['cost'],
                    "lowest_manufacturing_value_for_sale" => $product['sales'],
                ]);
                $done[] = $createdModel->barcode;
            } catch (Exception $e) {

                $failed[] = "Order: " . $ptr . ", Product weight: " . $product['weight'] . ", Manufacturing Value: " . $product['cost'] . ", Lowest Manufacturing Value for sale: " . $product['sales'];
            }
            $ptr++;
        endforeach;
        return back()->with([
            "done" => $done,
            "failed" => $failed
        ]);
    }

    public function createDiamondProducts()
    {
    }

    public function storeDiamondProducts()
    {
    }
}
