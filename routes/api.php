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

Route::middleware('guest:sanctum')->post('app-register', \App\Http\Controllers\Api\AppRegisterController::class);
Route::middleware('guest:sanctum')->post('login', \App\Http\Controllers\Api\AuthController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('app/purchase', [\App\Http\Controllers\Api\PurchaseController::class, 'store']);
    Route::post('app/renew', [\App\Http\Controllers\Api\PurchaseController::class, 'renew']);
    Route::post('app/cancel', [\App\Http\Controllers\Api\PurchaseController::class, 'cancel']);
    Route::get('app/check-subscriptions', [\App\Http\Controllers\Api\PurchaseController::class, 'checkSubscriptions']);
});
