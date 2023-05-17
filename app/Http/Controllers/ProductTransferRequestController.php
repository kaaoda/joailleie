<?php

namespace App\Http\Controllers;

use App\Models\ProductTransferRequest;
use App\Http\Requests\StoreProductTransferRequestRequest;
use App\Http\Requests\UpdateProductTransferRequestRequest;
use App\Models\Branch;
use App\Models\Product;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class ProductTransferRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transfers = ProductTransferRequest::with('branch')->withCount("products")->get();
        return view("entities.transfers.index", compact('transfers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("entities.transfers.createOrEdit", [
            'branches' => Branch::all(),
            'products' => Product::get(['id', 'barcode'])->toJson()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductTransferRequestRequest $request)
    {
        $safe = $request->safe()->toArray();
        try {
            DB::transaction(function () use ($safe) {
                $transfer = ProductTransferRequest::create([
                    "branch_id" => $safe['branch_id'],
                    "notices" => ""
                ]);
                $products = [];
                foreach ($safe['products'] as $product) {
                    $products[] = $product['id'];
                }
                $transfer->products()->sync($products);
                $transfer->products()->update([
                    'quarantined' => 1
                ]);
            });
            return response(["success" => "Request Added"]);
        } catch (Exception $e) {
            return response(["error" => $e->getMessage()], 500);
        }
        
        
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductTransferRequest $productTransferRequest)
    {
        $productTransferRequest->load('products')->load('branch');

        return view("entities.transfers.show", compact('productTransferRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductTransferRequest $productTransferRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductTransferRequestRequest $request, ProductTransferRequest $productTransferRequest)
    {
        try {
            if($productTransferRequest->approved) throw new Exception("Request already approved!");
            DB::transaction(function () use ($productTransferRequest, $request){
                $productTransferRequest->update(['approved' => 1]);
                $productTransferRequest->products()->update([
                    'branch_id' => $productTransferRequest->branch_id,
                    'quarantined' => 0
                ]);
            });
            return back()->with(['success' => 'Request Approved']);
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductTransferRequest $productTransferRequest)
    {
        try {
            $productTransferRequest->deleteOrFail();
            return response(["success" => "Product Transfer Request deleted"]);
        } catch (QueryException $e) {
            return response([
                "error" => "This record can't deleted!",
                "sql" => $e->getMessage()
            ], 400);
        }
    }
}
