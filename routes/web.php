<?php

use App\Http\Controllers\FormController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WhatsappController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('test-send-mail', [MailController::class, 'index']);
Route::get('form', [FormController::class, 'index']);
Route::post('form', [FormController::class, 'store'])->name('storeForm');
Route::get('payment', [PaymentController::class, 'show'])->name('showPayment');
Route::get('payment-success/{transactionId}', [PaymentController::class, 'showPaymentSuccess'])->name('showPaymentSuccess');

Route::get('send-wa', [WhatsappController::class, 'sendWa'])->name('sendWa');
