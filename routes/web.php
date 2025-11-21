<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransaksiOrderController;
use App\Http\Controllers\TransOrderController;
use App\Http\Controllers\TypeOfServiceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::get('/login', [AuthController::class, 'showLogin'])->name('login'); // buat view login
Route::post('/login', [AuthController::class, 'login'])->name('login.post'); // buat login proses
Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // buat logout

Route::middleware(['auth'])->group(function () {
   Route::get('/', [DashboardController::class, 'index'])->name('dashboard');


    Route::middleware(['role:Administrator'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('type_of_services', TypeOfServiceController::class);
    });
    Route::middleware(['role:Administrator,Operator'])->group(function () {
        Route::resource('customers', CustomerController::class);
        Route::resource('orders', TransOrderController::class);
        Route::get('/orders/{order}/print', [TransOrderController::class, 'print'])->name('orders.print');
        Route::get('get-all-data-orders', [TransOrderController::class, 'getAllDataOrders'])->name('orders.getAllDataOrders');
        Route::put('/orders/{id}/status', [TransOrderController::class, 'pickupLaundry'])->name('orders.pickupLaundry');
        Route::patch('/orders/{order}/complete', [TransOrderController::class, 'complete'])->name('orders.complete');
        Route::post('orders_post', [TransOrderController::class, 'newStore'])->name('orders.orders_post');
    });

    Route::middleware(['role:Administrator,Pimpinan'])->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/print', [ReportController::class, 'print'])->name('reports.print');

    });


});
