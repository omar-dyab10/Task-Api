<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/register', [App\Http\Controllers\Authcontroller::class, 'register']);
Route::post('/login', [App\Http\Controllers\Authcontroller::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Authcontroller::class, 'logout'])->middleware('auth:sanctum');
Route::apiResource('orders', OrderController::class)->middleware('auth:sanctum');