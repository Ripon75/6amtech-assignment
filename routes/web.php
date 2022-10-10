<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\Authcontroller;

Route::get('/', function () {
    return redirect()->route('products.index');
});

Route::prefix('admin')->group(function() {
    // Product bulk upload
    Route:: get('/products/bulk',  [ProductController::class, 'bulk'])->name('products.bulk');
    Route:: post('/products/bulk', [ProductController::class, 'bulkUpload'])->name('products.bulk.upload');
    // Product crud route
    Route::get('/login',    [Authcontroller::class, 'loginView'])->name('login.view');
    Route::get('/register', [Authcontroller::class, 'registerView'])->name('register.view');
    Route::resource('products', ProductController::class);
    // Permission crud route
    Route::resource('permissions', PermissionController::class);
    // Role crud route
    Route::resource('roles', RoleController::class);
});

