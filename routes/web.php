<?php

use App\Http\Controllers\FormController;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('test-send-mail', [MailController::class, 'index']);
Route::get('form', [FormController::class, 'index']);
Route::post('form', [FormController::class, 'store'])->name('storeForm');
