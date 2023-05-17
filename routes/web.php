<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DueController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ProductBulkController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTransferRequestController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SupplyTransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


require_once('auth.php');

Route::middleware("auth")->group(function(){
    Route::get('/', HomeController::class)->name("home");

    Route::resource('customers', CustomerController::class);

    Route::resource('users', UserController::class);

    Route::resource('suppliers', SupplierController::class);

    Route::resource('product_categories', ProductCategoryController::class);

    Route::resource('branches', BranchController::class);

    Route::resource('employees', EmployeeController::class);

    Route::resource('orders', OrderController::class);

    Route::post("products/ajax/searchByBarcode", [ProductController::class, "searchByBarcodeWithAjax"])->name("products.searchByBarcodeWithAjax");
    Route::resource('products', ProductController::class);

    Route::prefix("bulk")->name("bulk.")->group(function(){
        Route::get("createGoldProducts", [ProductBulkController::class, "createGoldProducts"])->name("createGoldProducts");
        Route::post("storeGoldProducts", [ProductBulkController::class, "storeGoldProducts"])->name("storeGoldProducts");

        Route::get("createDiamondProducts", [ProductBulkController::class, "createDiamondProducts"])->name("createDiamondProducts");
        Route::post("storeDiamondProducts", [ProductBulkController::class, "storeDiamondProducts"])->name("storeDiamondProducts");
    });

    Route::resource("invoices", InvoiceController::class);

    Route::resource("currencies", CurrencyController::class);

    Route::resource("supplier_transactions", SupplyTransactionController::class)->except(["create", "index"]);

    Route::resource("dues", DueController::class)->except(["create", "index", "show", "edit"]);

    Route::resource("transfers", ProductTransferRequestController::class);

    Route::resource("paymentMethods", PaymentMethodController::class);
});
