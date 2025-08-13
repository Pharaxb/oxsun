<?php

use App\Http\Controllers\Api\v1\AdController;
use App\Http\Controllers\Api\v1\AuthController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function(){
    Route::post('check-mobile', [AuthController::class, 'checkMobile']);
    Route::post('check-sms', [AuthController::class, 'checkSms']);
    //Route::get('test', [AdController::class, 'test']);

    Route::middleware(['auth:sanctum', 'throttle:api'])->group( function () {
        Route::post('get-ads', [AdController::class, 'getAds']);
        Route::post('set-ad', [AdController::class, 'store']);
        Route::post('show-ad', [AdController::class, 'show']);
        Route::post('seen-ad', [AdController::class, 'seen']);
        Route::post('bookmark', [AdController::class, 'bookmark']);
    });
});
