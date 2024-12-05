<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//products routes
Route::get('/products', [ProductController::class, 'getProductsByParam']);
Route::get('/products/featured-categories', [ProductController::class, 'getXNumOfProducts']);