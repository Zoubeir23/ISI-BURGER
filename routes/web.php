<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\BurgerController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\KioskController;

// Kiosk Routes
Route::get('/', [KioskController::class, 'index'])->name('kiosk.index');
Route::post('/order', [KioskController::class, 'store'])->name('kiosk.order.store');
Route::get('/checkout', [KioskController::class, 'checkout'])->name('kiosk.checkout');
Route::get('/confirmation', [KioskController::class, 'confirmation'])->name('kiosk.confirmation');
Route::get('/order/{id}/status', [KioskController::class, 'orderStatus'])->name('kiosk.order.status');


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn() => redirect()->route('admin.login'));

    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthController::class, 'login'])->name('login');
        Route::post('login', [AuthController::class, 'authenticate'])->name('authenticate');
    });

    Route::middleware('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Orders
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::get('orders/{order}/invoice', [OrderController::class, 'downloadInvoice'])->name('orders.invoice.download');
        Route::patch('orders/{order}/archive', [OrderController::class, 'archive'])->name('orders.archive');
        Route::patch('orders/{order}/restore', [OrderController::class, 'restore'])->name('orders.restore');
        Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

        // Payments
        Route::post('orders/{order}/payment', [PaymentController::class, 'store'])->name('orders.payment.store');

        // Burgers
        Route::resource('burgers', BurgerController::class);
        Route::patch('burgers/{burger}/restore', [BurgerController::class, 'restore'])->name('burgers.restore');

        // Stocks
        Route::get('stocks', [StockController::class, 'index'])->name('stocks.index');
        Route::patch('stocks/{burger}', [StockController::class, 'update'])->name('stocks.update');
    });
});
