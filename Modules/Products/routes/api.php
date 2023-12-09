<?php

use Illuminate\Support\Facades\Route;
use Modules\Products\app\Http\Controllers\ReviewController;
use Modules\Products\app\Http\Controllers\ProductsController;
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

    //* Manage Product: EditCredentials, Delete
    Route::group(['middleware' => ['can:Manage-Product-EditCredentials-Delete'], "prefix" => "product", "controller" => ProductsController::class], function () use ($router) {
        Route::post('credentials/update/{id}', 'updateProductCredentials');
        //Route::post('/{id}/delete', '');
    });

    //* Manage Product: Add, Edit
    Route::group(['middleware' => ['can:Manage-Product-Add-Edit'], "prefix" => "product", "controller" => ProductsController::class], function () use ($router) {
        Route::post('/create', 'createProduct');
        Route::post('/details/update/{id}', 'updateProductDetails');
    });

    //* Manage Product
    Route::group(['middleware' => ['can:Manage-Product'], "prefix" => "product", "controller" => ProductsController::class], function () use ($router) {
        Route::get('/', 'getAllProduct');
        Route::get('/{id}', 'getSingleProduct');
    });

    //* Manage Review
    Route::group(['middleware' => ['can:Manage-Review'], "prefix" => "review", "controller" =>ReviewController::class], function () use ($router) {
        Route::post('/create', 'createReview');
        Route::get('/', 'getAllReview');
        Route::get('/{id}', 'getSingleReview');
        Route::post('/{id}', 'updateReview');
        Route::get('/tree', 'getReviewTree');
    });

    //* Manage Wishlist
    Route::group(['middleware' => ['can:Manage-Wishlist'], "prefix" => "wishlist", "controller" => WishlistController::class], function () use ($router) {
        Route::post('/add', 'addProduct');
        Route::get('/', 'getAllWishlist');
        Route::post('/delete', 'deleteProductWishlist');
    });
});
