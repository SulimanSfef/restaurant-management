<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\WalletController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);


Route::middleware('auth:sanctum')->group(function () {

        Route::get('/user', [AuthController::class, 'user']);
        Route::post('/refresh', [AuthController::class, 'refreshToken']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/users/{id}', [UserController::class, 'updateProfile']);


        Route::post('/ratings', [RatingController::class, 'store']);
        Route::get('/ratings/{menu_item_id}', [RatingController::class, 'show']);
        Route::get('/menu-items/{id}/user-rating', [RatingController::class, 'userRating']);


        Route::get('/wallet/balance', [WalletController::class, 'balance']);
        Route::get('/wallet/transactions', [WalletController::class, 'transactions']);
        Route::post('/wallet/charge', [WalletController::class, 'charge']);
        Route::post('/orders/{order}/pay-wallet', [WalletController::class, 'payOrder']);



         Route::post('/user/orders', [OrderController::class, 'store']);
         Route::delete('/orders/{id}/cancel', [OrderController::class, 'cancel_Waiter']);



        Route::get('/my-orders/{order}/status', [UserOrderController::class, 'getOrderStatus']);
        Route::get('/my-orders', [UserOrderController::class, 'getMyOrders']);
        Route::delete('/orders/{id}/cancel', [UserOrderController::class, 'cancelOrder']);
        Route::post('/order-items', [OrderItemController::class, 'store']);
        Route::get('/orders/{orderId}/items', [OrderItemController::class, 'getByOrder']);


        Route::post('orders/{id}/requested', [OrderController::class, 'markAsRequested']);
        Route::post('orders/{id}/on-the-way', [OrderController::class, 'markAsOnTheWay']);







        Route::post('/addresses', [AddressController::class, 'store']);
        Route::delete('/addresses/{id}', [AddressController::class, 'destroy']);


        Route::get('/reservations', [ReservationController::class, 'index']);
        Route::get('/reservations/{reservation}', [ReservationController::class, 'show']);
        Route::post('/auto/reservations', [ReservationController::class, 'autoReserve']);
        Route::post('/reservations/{reservation}', [ReservationController::class, 'update']);
        Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy']);
        Route::put('/reservations/{id}/cancel', [ReservationController::class, 'cancel']);

        //جلب اوقات المحجوزة فيها الطاولة حسب التاريخ والرقم الطاولة
        Route::post('/get-booked-slots', [ReservationController::class, 'getBookedSlots']);
        Route::get('/my-reservations', [ReservationController::class, 'getUserReservations']);
        Route::post('/manual-reserve', [ReservationController::class, 'manualReserve']);

        Route::get('/offers', [OfferController::class, 'index']);

    Route::middleware('is.admin')->group(function () {

        Route::delete('/users/{id}', [UserController::class, 'destroy']);
        Route::put('/users/{id}/role', [UserController::class, 'updateRole']);

        Route::post('/categories', [CategoryController::class, 'store']);
        Route::put('/categories/{id}', [CategoryController::class, 'update']);
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

        Route::post('/menu-items/{category_id}', [MenuItemController::class, 'store']);

        Route::get('/users/{userId}/addresses', [AddressController::class, 'getByUser']);

        Route::get('/ratings/{menuItemId}/average', [RatingController::class, 'average']);


        Route::post('/offers/store', [OfferController::class, 'store']); // إضافة عرض جديد
        Route::get('/offers/show/{id}', [OfferController::class, 'show']); // عرض عرض معين
        Route::put('/offers/update/{id}', [OfferController::class, 'update']);
        Route::delete('/offers/destroy/{id}', [OfferController::class, 'destroy']);


    });

        Route::get('/categories', [CategoryController::class, 'index']);
        Route::get('/categories/{id}', [CategoryController::class, 'show']);


        Route::get('/menu-items', [MenuItemController::class, 'index']);
        Route::get('/menu-items/{menu_item}', [MenuItemController::class, 'show']);
        Route::put('/menu-items/{menu_item}', [MenuItemController::class, 'update']);
        Route::delete('/menu-items/{menu_item}', [MenuItemController::class, 'destroy']);

        Route::get('/tables', [TableController::class, 'index']);
        Route::get('/tables/{tableId}', [TableController::class, 'show']);
        Route::post('/tables', [TableController::class, 'store']);
        Route::put('/tables/{tableId}', [TableController::class, 'update']);
        Route::delete('/tables/{tableId}', [TableController::class, 'destroy']);


    Route::middleware('is.cashier')->group(function () {

        Route::resource('invoices', InvoiceController::class);

    });

    Route::middleware('is.chef')->group(function () {
        Route::get('/orders', [OrderController::class, 'index']);
        Route::get('/orders/{order}', [OrderController::class, 'show']);
        // بإمكانك إضافة مسارات تحديث حالة الطلب مثل:
        // Route::patch('/orders/{order}/prepare', [OrderController::class, 'prepare']);
    });

    Route::middleware('is.waiter')->group(function () {


        Route::post('/create/orders', [OrderController::class, 'store']);
        ///جديد

        Route::post('/by-waiter', [OrderController::class, 'storeByWaiter']);


        Route::post('orders/{id}/preparing', [OrderController::class, 'markAsPreparing']);
        Route::post('orders/{id}/paid', [OrderController::class, 'markAsPaid']);



    });

    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::post('/favorites/{menu_item_id}', [FavoriteController::class, 'store']);
    Route::delete('/favorites/{menu_item_id}', [FavoriteController::class, 'destroy']);


Route::get('/notifications', function () {
    $waiter = \App\Models\User::where('role', 'waiter')->first();
    return $waiter->notifications;
});


});


