<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function() {
    // product bulk upload
    Route:: get('/products/bulk',  [ProductController::class, 'bulk'])->name('products.bulk');
    Route:: post('/products/bulk', [ProductController::class, 'bulkUpload'])->name('products.bulk.upload');
    // product crud route
    Route::resource('products', ProductController::class);
});

