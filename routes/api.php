<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\Authcontroller;

Route::post('/register', [Authcontroller::class, 'register']);
Route::post('/login',    [Authcontroller::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
