<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('statement')->group(function () {
    Route::resource('bank-account', CamboDev\Statement\Controller\BankAccountController::class);
    Route::resource('chart-account', CamboDev\Statement\Controller\ChartAccountController::class);
    Route::resource('category', CamboDev\Statement\Controller\CategoryController::class);
    Route::resource('payment-method', CamboDev\Statement\Controller\PaymentMethodController::class);
    Route::resource('supplier', CamboDev\Statement\Controller\SupplyerController::class);
    Route::resource('entity', CamboDev\Statement\Controller\EntityController::class);
});
