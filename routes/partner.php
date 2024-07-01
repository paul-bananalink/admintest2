<?php

use Illuminate\Support\Facades\Route;


Route::group([
    'prefix' => 'login',
    'namespace' => 'App\Http\Controllers\Partner',
], function () {
    Route::get('', 'PartnerController@login')->name('login');
    Route::post('', 'PartnerController@authenticate')->name('authenticate');
    Route::get('/reload-captcha', 'PartnerController@reloadCaptcha')->name('reload-captcha');
});

Route::group([
    'namespace' => 'App\Http\Controllers\Partner',
    'middleware' => 'login_partner',
], function () {
    Route::group([
        'middleware' => 'check_new_notices',
    ], function () {
        // Route::get('/', fn () => redirect()->route('partner.dashboard.index'));

        Route::group(['as' => 'dashboard.', 'namespace'  => 'Dashboard', 'prefix' => 'dashboard'], function () {
            Route::get('/index', 'DashboardController@index')->name('index');
        });

        Route::group(['namespace' => 'Casino'], function () {
            Route::group(['prefix' => 'game', 'as' => 'game.'], function () {
                Route::get('{type}/index', 'CasinoController@index')->name('index');
            });
        });

        Route::group(['namespace' => 'Member', 'prefix' => 'settlement', 'as' => 'settlement.'], function () {
            Route::get('/index', 'SettlementController@index')->name('index');
        });

        Route::group(['namespace' => 'MoneyInfo', 'prefix' => 'money-info', 'as' => 'money-info.', 'where' => ['type' => 'recharge|withdraw']], function () {
            Route::get('/{type}/index', 'MoneyInfoController@index')->name('index');
            Route::post('/{type}/update/{id}', 'MoneyInfoController@update')->name('update');
            Route::post('/{type}/update-ids', 'MoneyInfoController@updateIds')->name('update-ids');
            Route::post('/direct-recharge-or-withdraw/{mID}', 'MoneyInfoController@directRechargeOrWithdraw')->name('direct-recharge-or-withdraw');
            Route::get('/{type}/histories/{id}', 'MoneyInfoController@histories')->name('histories');
            Route::delete('/{type}/delete/{id}', 'MoneyInfoController@destroy')->name('delete');
        });

        Route::group(['namespace' => 'Member', 'as' => 'status-members.', 'prefix' => 'status-members'], function () {
            /**
             * namespace: App\Http\Controllers\Partner\Member
             * as: partner.status-members.
             * prefix: partner/status-members/
             */
            Route::get('/index', 'StatusMemberController@index')->name('index');
        });

        Route::group(['namespace' => 'Bonus', 'prefix' => 'bonus', 'as' => 'bonus.'], function () {
            Route::get('/index', 'BonusController@index')->name('index');
            Route::get('/info/{id}', 'BonusController@info')->name('info');
        });

        Route::group(['prefix' => 'betting-histories', 'as' => 'betting-histories.'], function () {
            Route::get('/mini-game', 'BettingHistoryController@miniGame')->name('miniGame');
            Route::get('/parsing-casino', 'BettingHistoryController@parsingCasino')->name('parsingCasino');
            Route::get('/casino', 'BettingHistoryController@casino')->name('casino');
        });

        Route::group(['namespace' => 'PartnerManager', 'prefix' => 'manager', 'as' => 'manager.'], function () {
            Route::get('/index', 'PartnerManagerController@index')->name('index');
            Route::get('/{level_type}/index', 'PartnerManagerController@indexLevel')->name('indexLevel');
        });

        Route::group(['as' => 'coupon.', 'namespace'  => 'Coupon', 'prefix' => 'coupon'], function () {
            Route::get('/index', 'CouponController@index')->name('index');
        });

        Route::group(['namespace' => 'PointHistory', 'prefix' => 'point-history', 'as' => 'point-history.'], function () {
            Route::get('/index', 'PointHistoryController@index')->name('index');
        });

        Route::group(['as' => 'notice.', 'namespace'  => 'Notice', 'prefix' => 'notice'], function () {
            Route::get('/index', 'NoticeController@index')->name('index');

            //Ajax
            Route::get('/ajax-show-content/{ntNo}', 'NoticeController@ajaxGetContent')->name('ajax-show-content');
        });

        Route::group(['as' => 'cash.', 'namespace'  => 'Cash', 'prefix' => 'cash'], function () {
            Route::get('/index', 'CashController@index')->name('index');
        });
    });

    Route::get('/logout', 'PartnerController@logout')->name('logout');
});
