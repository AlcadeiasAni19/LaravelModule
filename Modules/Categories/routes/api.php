<?php

use Illuminate\Support\Facades\Route;
use Modules\Categories\app\Http\Controllers\CategoriesController;

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
    Route::group(["prefix" => "category", "controller" => CategoriesController::class], function () use ($router) {

        //* Manage Category: Edit, Delete
        Route::group(['middleware' => ['can:Manage-Category-Edit-Delete']], function () use ($router) {
            Route::post('/{id}', 'updateCategory');
            //Route::get('single/details/{id}', 'singleDeatilsCategory');
        });

        //* Manage Category: Add
        Route::group(['middleware' => ['can:Manage-Category-Add']], function () use ($router) {
            Route::post('/new/create', 'createCategory');
        });

        //* Manage Category
        Route::group(['middleware' => ['can:Manage-Category']], function () use ($router) {
            Route::get('/', 'getAllCategory');
            Route::get('/{id}', 'getSingleCategory');
        });
    });
});
