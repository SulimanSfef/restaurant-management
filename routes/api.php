<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;

use App\Http\Controllers\TableController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\OrderItemController;


Route::middleware('auth:sanctum')->get('/users', function (Request $request) {
    return $request->user();
});


           ////////////////// Auth  /////////////////////
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

               ///////////// نسيان الكلمة ////////////
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/refresh', [AuthController::class, 'refreshToken']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::middleware('is.admin')->group(function () {
        
       Route::delete('/users/{id}', [UserController::class, 'destroy']);

    });
});

Route::resource('tables', TableController::class);
Route::resource('categories', CategoryController::class);
Route::post('/Add_categories', [CategoryController::class, 'store']);
Route::resource('menu-items', MenuItemController::class);
Route::post('/menu-items/{category_id}', [MenuItemController::class, 'store']);

Route::resource('orders', OrderController::class);
Route::resource('invoices', InvoiceController::class);
Route::resource('reservations', ReservationController::class);
Route::resource('order-items', OrderItemController::class);
