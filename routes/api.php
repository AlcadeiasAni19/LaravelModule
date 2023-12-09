<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Modules\Carts\app\Http\Controllers\OrderController;

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

Route::post('/login', [UserController::class, 'Login']);
//User Logged in or Not Checking middleware
Route::post('/logout', [UserController::class, 'Logout']);

Route::group(['middleware' => ['auth:sanctum']], function () use ($router){
    Route::group(["prefix" => "user", "controller" => UserController::class], function () use ($router) {
        
        //* Manage User: Edit Credentials
        Route::group(['middleware' => ['can:Manage-User-EditCredentials']], function () use ($router) {
            Route::post('credential/update/{id}', 'updateUserCredentials');
            Route::post('/delete/{id}', 'deleteUser');
        });
        
        //* Manage User: Add, ViewAll
        Route::group(['middleware' => ['can:Manage-User-Add-ViewAll']], function () use ($router) {
            Route::post('/new/create', 'createUser');
            Route::get('/', 'getAllUser');
            Route::get('/products/of/{id}', 'showUserProducts');
            Route::get('/categories/of/{id}', 'showUserCategories');
        });

        //* Manage User
        Route::group(['middleware' => ['can:Manage-User']], function () use ($router) {
            Route::get('/{id}', 'getSingleUser');
            Route::post('details/update/{id}', 'updateUserDetails');
        });
    });
    
    //*Manage Wishlist
    Route::group(['middleware' => ['can:Manage-Wishlist'], "prefix" => "wishlist", "controller" => UserController::class], function () use ($router) {
        Route::post('/delete/of-user/{id}', 'deleteWishlist');
    }); 

    //* Manage Cart
    Route::group(['middleware' => ['can:Manage-Cart'], "prefix" => "cart", "controller" => UserController::class], function () use ($router) {
        Route::get('/of-user/{id}', 'getUserCart');
        Route::post('/quantity/update/of-user/{id}', 'updateCartProductQuantity');
        Route::post('/product/delete/of-user/{id}', 'deleteCartProduct');
        Route::post('/delete/of-user/{id}', 'deleteCart');
    });
    
    //* Manage Order
    Route::group(['middleware' => ['can:Manage-Order'], "prefix" => "order", "controller" => OrderController::class], function () use ($router) {
        Route::post('/create/of-user/{id}', 'createOrder');
    });
});
