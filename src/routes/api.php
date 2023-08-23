<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('api')->group(function () {
    Route::resource('bank-account', CamboDev\Statement\Controller\BankAccountController::class);
    Route::resource('chart-account', CamboDev\Statement\Controller\ChartAccountController::class);
    Route::resource('category', CamboDev\Statement\Controller\CategoryController::class);
    Route::resource('payment-method', CamboDev\Statement\Controller\PaymentMethodController::class);
});
