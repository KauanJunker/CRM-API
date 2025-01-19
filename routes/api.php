<?php

use App\Http\Controllers\Api\V1\ContactController;
use App\Http\Controllers\Api\V1\LeadController;
use App\Http\Controllers\Api\V1\RelatorioController;
use App\Http\Controllers\Api\V1\TaskController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Middleware\GateDefineMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->controller(UserController::class)->group(function() {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::prefix('v1')->middleware('auth:sanctum')->controller(ContactController::class)->group( function() {
    Route::get('contact', 'index');
    Route::get('contact/{id}', 'show');
    Route::post('contact', 'store');
    Route::put('contact/{id}', 'update');
    Route::patch('contact/{id}', 'update');
    Route::delete('contact/{id}', 'destroy');
});

Route::prefix('v1')->middleware('auth:sanctum')->controller(LeadController::class)->group(function() {
    Route::get('lead', 'index');
    Route::get('lead/{id}', 'show');
    Route::post('lead', 'store');
    Route::put('lead/{id}', 'update');
    Route::patch('lead/{id}', 'update');
    Route::delete('lead/{id}', 'destroy');
});

Route::prefix('v1')->middleware('auth:sanctum')->controller(TaskController::class)->group(function() {
    Route::get('task', 'index');
    Route::get('task/{id}', 'show');
    Route::post('task', 'store');
    Route::put('task/{id}', 'update');
    Route::patch('task/{id}', 'update');
    Route::delete('task/{id}', 'destroy');
    Route::get('completeTask/{id}', 'completeTask');
});

Route::prefix('v1')->middleware('auth:sanctum')->controller(RelatorioController::class)->group(function() {
    Route::get('quantidadeLeadPorStatus', 'quantidadeLeadPorStatus');
    Route::get('tarefasPendentes', 'tarefasPendentes');
    Route::get('tarefasConcluidas', 'tarefasConcluidas');
    Route::get('contatosLeadsMaisAtivos', 'contatosLeadsMaisAtivos');
});
