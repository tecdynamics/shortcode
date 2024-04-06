<?php

use Tec\Base\Facades\AdminHelper;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Tec\Shortcode\Http\Controllers'], function () {
    AdminHelper::registerRoutes(function () {
        Route::group(['prefix' => 'short-codes'], function () {
            Route::post('ajax-get-admin-config/{key}', [
                'as' => 'short-codes.ajax-get-admin-config',
                'uses' => 'ShortcodeController@ajaxGetAdminConfig',
                'permission' => false,
            ]);
        });
    });
});
