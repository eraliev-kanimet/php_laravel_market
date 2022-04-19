<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use Illuminate\Support\Facades\Route;

Route::post('/oauth/register', [AuthController::class, 'register']);
Route::post('/oauth/login', [AuthController::class, 'login']);
Route::apiResource('categories', CategoriesController::class);
Route::get('subcategories/{category}', [CategoriesController::class, 'subcategories']);
