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
        // 第三方登录
        Route::post('socials/{social_type}/authorizations', 'AuthorizationsController@socialStore')
            ->where('socail_type', 'weixin')
            ->name('socials.authorizations.store');
        // 账号密码登录
        Route::post('authorizations', 'AuthorizationsController@store')
            ->name('authorizations.store');
        // 刷新token
        Route::put('authorizations/current', 'AuthorizationsController@update')
            ->name('authorizations.update');
        // 删除token
        Route::delete('authorizations/current', 'AuthorizationsController@destroy')
            ->name('authorizations.destroy');
    });

    Route::middleware('throttle:' . config('api.rate_limits.access'))->group(function() {
        // 游客可以访问的接口

        // 某个用户的详情
        Route::get('users/{user}', 'UsersController@show')
            ->name('users.show');

        // 登录后可以访问的接口
        Route::middleware('auth:api')->group(function() {
            // 当前登录用户信息
            Route::get('user', 'UsersController@me')
                ->name('user.show');
            // 上传图片
            Route::post('images', 'ImagesController@store')
                ->name('images.store');
            // 编辑登录用户
            Route::patch('user', 'UsersController@update')
                ->name('user.update');
        });
    });
});
