<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ProductController;

// Auth route
Route::post('/register', [Authcontroller::class, 'register']);
Route::post('/login',    [Authcontroller::class, 'login']);

// Get product route
Route::get('/products/list', [ProductController::class, 'getProduct']);

Route::middleware(['auth:api'])->group(function() {
    Route::get('user/details', [Authcontroller::class, 'userDetail']);
});
