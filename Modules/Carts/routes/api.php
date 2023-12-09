<?php

use Illuminate\Support\Facades\Route;
use Modules\Carts\app\Http\Controllers\CartsController;
use Modules\Carts\app\Http\Controllers\TransactionController;
use Modules\Products\app\Http\Controllers\WishlistController;

/*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
*/

Route::group(['middleware' => ['auth:sanctum']], function () use ($router){
    //* Manage Cart
    Route::group(['middleware' => ['can:Manage-Cart']], function () use ($router) {
        Route::post('/cart/add', [CartsController::class, 'addProduct']);
        Route::get('/cart', [CartsController::class,'getAllCart']);
    });

    //* Manage Wishlist
    Route::group(['middleware' => ['can:Manage-Wishlist'], "prefix" => "wishlist", "controller" => WishlistController::class], function () use ($router) {
        Route::post('/add', 'addProduct');
        Route::get('/', 'getAllWishlist');
        Route::get('/delete', 'deleteProductWishlist');
    });
    
    //* Manage Transaction
    Route::group(['middleware' => ['can:Manage-Transaction']], function () use ($router) {
        Route::post('/transaction/create', [TransactionController::class, 'createTransaction']);        
    });
});
