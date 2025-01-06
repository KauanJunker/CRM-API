<?php

use App\Http\Controllers\Api\V1\ContactController;
use App\Http\Controllers\Api\V1\LeadController;
use App\Http\Controllers\Api\V1\TaskController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::prefix('v1')->controller(UserController::class)->group(function() {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::prefix('v1')->controller(ContactController::class)->group(function() {
    Route::get('contact', 'index')->middleware('auth:sanctum');
    Route::get('contact/{id}', 'show')->middleware('auth:sanctum');
    Route::post('contact', 'store')->middleware('auth:sanctum');
    Route::put('contact/{id}', 'update')->middleware('auth:sanctum');
    Route::patch('contact/{id}', 'update')->middleware('auth:sanctum');
    Route::delete('contact/{id}', 'destroy')->middleware('auth:sanctum');
});

Route::prefix('v1')->controller(LeadController::class)->group(function() {
    Route::get('lead', 'index')->middleware('auth:sanctum');
    Route::get('lead/{id}', 'show')->middleware('auth:sanctum');
    Route::post('lead', 'store')->middleware('auth:sanctum');
    Route::put('lead/{id}', 'update')->middleware('auth:sanctum');
    Route::patch('lead/{id}', 'update')->middleware('auth:sanctum');
    Route::delete('lead/{id}', 'destroy')->middleware('auth:sanctum');
});

Route::prefix('v1')->controller(TaskController::class)->group(function() {
    Route::get('task', 'index')->middleware('auth:sanctum');
    Route::get('task/{id}', 'show')->middleware('auth:sanctum');
    Route::post('task', 'store')->middleware('auth:sanctum');
    Route::put('task/{id}', 'update')->middleware('auth:sanctum');
    Route::patch('task/{id}', 'update')->middleware('auth:sanctum');
    Route::delete('task/{id}', 'destroy')->middleware('auth:sanctum');
});

// Route::prefix('v1')->controller(ProductController::class)->group(function() {
//     Route::get('products', 'products')->middleware('auth:sanctum');
// });

// Route::get('/products', [ProductController::class, 'products'])->middleware('auth:sanctum');
