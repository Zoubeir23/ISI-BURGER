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

        // Payments
        Route::post('orders/{order}/payment', [PaymentController::class, 'store'])->name('orders.payment.store');

        // Burgers
        Route::resource('burgers', BurgerController::class);

        // Stocks
        Route::get('stocks', [StockController::class, 'index'])->name('stocks.index');
        Route::patch('stocks/{burger}', [StockController::class, 'update'])->name('stocks.update');
    });
});
