<?php

use App\Http\AdminControllers\CategoriesController;
use App\Http\AdminControllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('categories/all', [CategoriesController::class, 'all'])->name('categories.all');
Route::get('products/category/{category}', [ProductController::class, 'categoryProducts'])->name('products.category');
Route::apiResource('categories', CategoriesController::class);
Route::apiResource('products', ProductController::class);