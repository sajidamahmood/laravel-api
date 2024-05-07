<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\apiProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;





Route::middleware('auth:sanctum')->group(function () {
    // Define your resource management routes here
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// routes/api.php


// Public Access Page v1
Route::get('/v1/welcome', function () {
    return response()->json(['message' => 'Welcome to the login/welcome page']);
});



    

    Route::group(['prefix' =>'/v1'], function(){

    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);

    Route::get('/Users', UserController::class . '@index')->middleware(['auth:sanctum'])->name('index.Users');
    Route::post('/Users', UserController::class . '@store')->middleware(['auth:sanctum'])->middleware(['auth'])->name('store.Users');
    Route::get('/Users/{id}', UserController::class . '@show')->middleware(['auth:sanctum'])->name('show.Users');
    Route::put('/Users/{id}/edit', UserController::class . '@update')->middleware(['auth:sanctum'])->name('update.Users');
    Route::delete('/Users/{id}/edit',UserController::class . '@destroy')->middleware(['auth:sanctum'])->name('destroy.Users');


   
    Route::get('/products', ApiProductController::class . '@index')->middleware(['auth:sanctum'])->name('index.products');
    Route::post('/products', ApiProductController::class . '@store')->middleware(['auth:sanctum'])->name('store.products');
    Route::get('/products/{id}', ApiProductController::class . '@show')->middleware(['auth:sanctum'])->name('show.products');
    Route::put('/products/{id}/edit', ApiProductController::class . '@update')->middleware(['auth:sanctum'])->name('update.products');
    Route::delete('/products/{id}/edit', ApiProductController::class . '@destroy')->middleware(['auth:sanctum'])->name('destroy.products');

  
   
    Route::get('/categories', CategoryController::class . '@index')->middleware(['auth:sanctum'])->name('index.categories');
    Route::post('/categories', CategoryController::class . '@store')->middleware(['auth:sanctum'])->name('store.categories');
    Route::get('/categories/{id}', CategoryController::class . '@show')->middleware(['auth:sanctum'])->name('show.categories');
    Route::put('/categories/{id}/edit', CategoryController::class . '@update')->middleware(['auth:sanctum'])->name('update.categories');
    Route::delete('/categories/{id}/edit', CategoryController::class . '@destroy')->middleware(['auth:sanctum'])->name('destroy.categories');
    
    });