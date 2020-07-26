<?php

use Illuminate\Http\Request;

// 控制器（如：VerificationCodesController）放在了 Api 目录中， 所以还需要调整一下统一的命名空间，使用 namespace 方法即可
Route::prefix('v1')->namespace('Api')->name('api.v1.')->group(function() {

    Route::middleware('throttle:' . config('api.rate_limits.sign'))->group(function() {
        // 图片验证码
        Route::post('captchas', 'CaptchasController@store')
            ->name('captchas.store');
        // 短信验证码
        Route::post('verificationCodes', 'VerificationCodesController@store')
            ->name('verificationCodes.store');
        // 用户注册
        Route::post('users', 'UsersController@store')
            ->name('users.store');
    });

    Route::middleware('throttle:' . config('api.rate_limits.access'))->group(function() {

    });
});
