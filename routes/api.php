<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FavoriteController;


//////////////////// AUTH ////////////////////
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

//////////////////// LOGGED IN ROUTES ////////////////////
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/refresh', [AuthController::class, 'refreshToken']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // ⭐⭐ Ratings (General for all authenticated users)
    Route::post('/ratings', [RatingController::class, 'store']);
    Route::get('/ratings/{menu_item_id}', [RatingController::class, 'show']);

    //////////////////// ADMIN ROUTES ////////////////////
    Route::middleware('is.admin')->group(function () {
        Route::delete('/users/{id}', [UserController::class, 'destroy']);

        // إدارة الطاولات - فقط الأدمن
        Route::resource('tables', TableController::class);


        Route::post('/categories', [CategoryController::class, 'store']);
        Route::put('/categories/{id}', [CategoryController::class, 'update']);
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

        // إدارة عناصر القائمة - فقط الأدمن
        Route::post('/menu-items/{category_id}', [MenuItemController::class, 'store']);
        // ادارة ادوار المستخدمين
        Route::put('/users/{id}/role', [UserController::class, 'updateRole']);
    });
        Route::get('/categories', [CategoryController::class, 'index']);
        Route::get('/categories/{id}', [CategoryController::class, 'show']);




        Route::get('/menu-items', [MenuItemController::class, 'index']);
        Route::get('/menu-items/{menu_item}', [MenuItemController::class, 'show']);
        Route::put('/menu-items/{menu_item}', [MenuItemController::class, 'update']);
        Route::delete('/menu-items/{menu_item}', [MenuItemController::class, 'destroy']);

        Route::get('/tables', [TableController::class, 'index']);
        Route::get('/tables/{tableId}', [TableController::class, 'show']);
        Route::post('/tables/{tableId}', [TableController::class, 'store']);
        Route::put('/tables/{tableId}', [TableController::class, 'update']);
        Route::delete('/tables/{tableId}', [TableController::class, 'destroy']);

    //////////////////// CASHIER ROUTES ////////////////////
    Route::middleware('is.cashier')->group(function () {
        // إدارة الفواتير - الكاشير
        Route::resource('invoices', InvoiceController::class);

        // إدارة الطلبات - الكاشير
        Route::resource('orders', OrderController::class);
    });

    //////////////////// CHEF ROUTES ////////////////////
    Route::middleware('is.chef')->group(function () {
        // عرض وتحضير الطلبات - الطباخ
        Route::get('/orders', [OrderController::class, 'index']);
        Route::get('/orders/{order}', [OrderController::class, 'show']);
        // بإمكانك إضافة مسارات تحديث حالة الطلب مثل:
        // Route::patch('/orders/{order}/prepare', [OrderController::class, 'prepare']);
    });

    //////////////////// WAITER ROUTES ////////////////////
    Route::middleware('is.waiter')->group(function () {
        // الطلبات
        Route::resource('orders', OrderController::class)->only(['index', 'store']);

        // جلب كل الحجوزات
Route::get('/reservations', [ReservationController::class, 'index']);

// جلب حجز معين
Route::get('/reservations/{reservation}', [ReservationController::class, 'show']);

// إنشاء حجز جديد
Route::post('/reservations', [ReservationController::class, 'store']);

// تعديل حجز
Route::put('/reservations/{reservation}', [ReservationController::class, 'update']);

// حذف حجز
Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy']);

        // عناصر الطلب
        Route::resource('order-items', OrderItemController::class);
    });



    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::post('/favorites/{menu_item_id}', [FavoriteController::class, 'store']);
    Route::delete('/favorites/{menu_item_id}', [FavoriteController::class, 'destroy']);

    Route::get('/tables/capacity/{peopleCount}', [TableController::class, 'getTablesByCapacity']);
    Route::get('/tables/sorted/by-reservations', [TableController::class, 'tablesSortedByReservations']);


});


