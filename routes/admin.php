<?php

use App\Http\AdminControllers\CategoriesController;
use App\Http\AdminControllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('categories/all', [CategoriesController::class, 'getAll'])->name('categories.all');
Route::apiResource('categories', CategoriesController::class);
Route::apiResource('products', ProductController::class);
Route::get('products/category/{category}', [ProductController::class, 'getCategoryProducts'])->name('products.category');