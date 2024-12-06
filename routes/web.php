<?php

use Tec\Base\Facades\AdminHelper;
use Tec\Base\Http\Middleware\RequiresJsonRequestMiddleware;
use Tec\Shortcode\Http\Controllers\ShortcodeController;
use Tec\Theme\Facades\Theme;
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

app()->booted(function () {
    Route::middleware(RequiresJsonRequestMiddleware::class)->group(function () {
        Theme::registerRoutes(function () {
            Route::post('ajax/render-ui-blocks', [ShortcodeController::class, 'ajaxRenderUiBlock'])
                ->name('public.ajax.render-ui-block');
        });
    });
});
