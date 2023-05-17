<?php

use App\Http\Controllers\Auth\LoginController;
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

Route::prefix("auth")->group(function(){
    Route::middleware('guest')->group(function(){
        Route::get("login", [LoginController::class, 'showLoginForm'])->name('login');
        Route::post("login", [LoginController::class, 'proccessingLoginRequest'])->name('login.processing');
    });
    Route::middleware('auth')->get('logout', [LoginController::class, 'logout'] )->name('logout');
});
