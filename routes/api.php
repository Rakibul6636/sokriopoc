<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SaleController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['auth:sanctum']], function () {
    //Route for add products
    Route::controller(ProductController::class)->group(function(){
        Route::post('products', 'create')->name('products');
    
    });
     //Route for add stocks
    Route::controller(StockController::class)->group(function(){
        Route::post('stocks',  'create')->name('stocks');
    
    });
     //Route for add sales
    Route::controller(SaleController::class)->group(function(){
        Route::post('sales', 'create')->name('sales');
    
    });
});

Route::controller(AuthController::class)->group(function(){
    Route::get('showRegister','showRegister')->name('showRegister');
    Route::get('showLogin','showLogin')->name('showLogin'); 
    Route::any('login','login')->name('login');
    Route::any('register','register')->name('register');
});
//show the Product form
Route::controller(ProductController::class)->group(function(){
    Route::get('productsShow', 'showProduct')->name('showProduct');

});
//show the Stock form
Route::controller(StockController::class)->group(function(){
    Route::get('stocksShow',  'showStock')->name('showStock');

});
//show the Sale form
Route::controller(SaleController::class)->group(function(){
    Route::get('salesShow', 'showSale')->name('showSale');
});
