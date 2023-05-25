<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Currency;
use App\Models\Diamond;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Supplier;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Milon\Barcode\DNS1D;

class ProductBulkController extends Controller
{
    public function createGoldProducts()
    {
        return view("entities.bulk.products.createGold",[
            "suppliers" => Supplier::all(["id", "name"]),
            "branches" => Branch::all(["id", "name"]),
            "categories" => ProductCategory::whereRelation("division", "name", "=", "GOLD")->with("division:id,name")->get(["id", "name", "product_division_id"])->groupBy("division.name")
        ]);
    }

    public function storeGoldProducts(Request $request)
    {
        //dd($request);
        $request->validate([
            'products.products' => 'required|array',
            'products.products.*' => 'required|array|size:6'
        ]);
        $products = $request->input()['products']['products'];
        $done = [];
        $failed = [];
        $ptr = 1;
        foreach($products as $idiot => $product):
            try {
                if (array_search(NULL, array_values($product)) !== FALSE) throw new Exception();
                $createdModel = Product::create([
                    "product_category_id" => $product['category_id'],
                    "branch_id" => $product['branch_id'],
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
        return redirect()->route('bulk.printBarcode')->with([
            "done" => $done,
            "failed" => $failed
        ]);
    }
    
    public function printBarcode(Request $request)
    {
        $products = [];
        if($request->session()->has('done'))
        {
            foreach($request->session()->get('done') as $barcode)
            {
                $product = Product::where('barcode', '=', $barcode)->firstOrFail();
                $products[] = [...$product->toArray(), 'barcode_image' => DNS1D::getBarcodeSVG($barcode, "C128", 0.5, 30)];
            }
        }
        
        if($request->query('barcode'))
        {
            foreach($request->query('barcode') as $barcode)
            {
                $product = Product::where('barcode', '=', $barcode)->firstOrFail();
                $products[] = [...$product->toArray(), 'barcode_image' =>  DNS1D::getBarcodePNG($barcode, "C128", 1.2, 25)];
            }
        }
        
        //dd($products);
        if(count($products) == 0) return back();
        return view("entities.bulk.products.barcodePrint", compact('products'));
    }

    public function createDiamondProducts()
    {
        return view("entities.bulk.products.createDiamond", [
            "suppliers" => Supplier::all(["id", "name"]),
            "branches" => Branch::all(["id", "name"]),
            "currencies" => Currency::all(['id', 'name']),
            "categories" => ProductCategory::whereRelation("division", "name", "=", "DIAMOND")->with("division:id,name")->get(["id", "name", "product_division_id"])->groupBy("division.name")
        ]);
    }

    public function storeDiamondProducts(Request $request)
    {
        //dd($request);
        $request->validate([
            'outer-list' => 'required|array',
            'outer-list.*' => 'required|array',
            'outer-list.*.inner-list' => 'required|array',
            'outer-list.*.inner-list.*' => 'required|array|size:6',
            "currency_id" => "required|exists:currencies,id"
        ]);
        $products = $request->input()['outer-list'];
       // dd($products);
        
        
        $response = DB::transaction(function () use ($products, $request) {
            $ptr = 1;
            $done = [];
            $failed = [];
            foreach ($products as  $product) :
                try {                    
                        $createdModel = Product::create([
                            "product_category_id" => $product['category_id'],
                            "branch_id" => $product['branch_id'],
                            "supplier_id" => $product['supplier_id'],
                            "weight" => $product['weight'],
                            "thumbnail_path" => NULL,
                            "barcode" => NULL,
                            "kerat" => '18',
                            "cost" => 0,
                            "manufacturing_value" => $product['cost'],
                            "lowest_manufacturing_value_for_sale" => $product['sales'],
                        ]);
                        foreach($product['inner-list'] as $diamond)
                        {
                            Diamond::create([
                                "diamondable_type" => Product::class,
                                "diamondable_id" => $createdModel->id,
                                "number_of_stones" => $diamond['number_of_stones'],
                                "weight" => $diamond['weight'],
                                "clarity" => $diamond['clarity'],
                                "color" => $diamond['color'],
                                "shape" => $diamond['shape'],
                                "price" => $diamond['price'],
                                "currency_id" => $request->get('currency_id'),
                                "exchange_rate" => Currency::find($request->get('currency_id'))->exchange_rate
                            ]);
                        }
                        $done[] = $createdModel->barcode;
                    
                    
                } catch (Exception $e) {

                    $failed[] = "Reason: " .$e->getMessage() . ", Order: " . $ptr . ", Product weight: " . $product['weight'] . ", Manufacturing Value: " . $product['cost'] . ", Lowest Manufacturing Value for sale: " . $product['sales'];
                }
                $ptr++;
            endforeach;
            return [
                "done" => $done,
                "failed" => $failed
            ];
        });
        return redirect()->route('bulk.printBarcode')->with($response);
    }
}
