<?php

use App\Http\Controllers\Api\v1\AdController;
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\AdFilterController;
use App\Http\Controllers\Api\v1\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function(){
    //Route::get('test', [AdController::class, 'test']);

    Route::group(['prefix' => 'auth'], function(){
        Route::post('check-mobile', [AuthController::class, 'checkMobile']);
        Route::post('check-sms', [AuthController::class, 'checkSms']);
    });

    Route::middleware(['auth:sanctum', 'throttle:api'])->group( function () {
        Route::group(['prefix' => 'ad'], function(){
            Route::get('list', [AdController::class, 'getAds']);
            Route::post('store', [AdController::class, 'store']);
            //Route::post('show', [AdController::class, 'show']);
            //Route::post('seen', [AdController::class, 'seen']);
            //Route::post('bookmark', [AdController::class, 'bookmark']);
        });

        Route::group(['prefix' => 'user'], function(){
            Route::get('show', [UserController::class, 'show']);
            Route::post('update', [UserController::class, 'update']);
        });

        Route::group(['prefix' => 'filters'], function(){
            Route::get('province', [AdFilterController::class, 'getProvinces']);
            Route::get('city', [AdFilterController::class, 'getCities']);
            Route::get('district', [AdFilterController::class, 'getDistricts']);
            Route::get('operators', [AdFilterController::class, 'getOperators']);
            Route::get('ages', [AdFilterController::class, 'getAges']);
        });
    });
});
