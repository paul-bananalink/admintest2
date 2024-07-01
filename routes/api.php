<?php

use Illuminate\Support\Facades\Route;

Route::namespace('App\Http\Controllers\Api')->group(function () {
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::group(['as' => 'integration-api.', 'prefix' => 'integration-api'], function () {
            Route::get('/balance', 'IntegrationAPIController@getBalance')->name('get-balance');
            Route::get('/game-providers', 'IntegrationAPIController@getGameProviders')->name('get-game-providers');
            Route::get('/games', 'IntegrationAPIController@getGames')->name('get-games');
            Route::post('/launch-game', 'IntegrationAPIController@launchGame')->name('launch-game');
            Route::post('/kick-player', 'IntegrationAPIController@kickPlayer')->name('kick-player');
        });

        Route::group(['as' => 'data-feed.', 'prefix' => 'data-feed'], function () {
            Route::get('/transaction', 'DataFeedAPIController@getTransaction')->name('get-transaction');
            Route::get('/transactions', 'DataFeedAPIController@getTransactions')->name('get-transactions');
            Route::post('/open-game-history', 'DataFeedAPIController@openGameHistory')->name('open-game-history');
            Route::get('/game-round-details-by-id', 'DataFeedAPIController@gameRoundDetailsById')->name('game-round-details-by-id');
            Route::get('/game-round-details', 'DataFeedAPIController@gameRoundDetails')->name('game-round-details');
            Route::post('/game-history-details', 'DataFeedAPIController@gameHistoryDetails')->name('game-history-details');
        });

        Route::group(['as' => 'bt1.', 'prefix' => 'bt1'], function () {
            Route::post('/verify-token', 'BT1Controller@verifyToken')->name('verify-token');
            Route::post('/refresh-token', 'BT1Controller@refreshToken')->name('refresh-token');
        });
    });

    Route::group(['prefix' => 'callback', 'middleware' => ['verify_auth_header']], function () {
        Route::get('/Balance', 'CallbackAPIController@getBalance')->name('Balance');
        Route::get('/balance', 'CallbackAPIController@getBalance')->name('balance');
        Route::post('/Transaction', 'CallbackAPIController@postTransaction')->name('Transaction');
        Route::post('/transaction', 'CallbackAPIController@postTransaction')->name('transaction');
    });
});
