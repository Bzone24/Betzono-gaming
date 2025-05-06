<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\SportsApiController;

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



Route::controller(ApiController::class)->group(function () {
    Route::post('/Login', 'login')->name('login');
    Route::post('/validateuser', 'ValidateUser')->name('ValidateUser');
    Route::post('/getbalance', 'getBalance')->name('getBalance');
    Route::post('/placebet', 'placeBet')->name('placeBet');
    Route::post('/cancelbet', 'CancelBet')->name('CancelBet');
    Route::post('/settlegame', 'settleGame')->name('settleGame');
    Route::post('/resettlegame', 'resettleGame')->name('resettleGame');
    Route::post('/deposit', 'deposit')->name('deposit');
    Route::post('/check-balance', 'checkBalance')->name('check-balance');
    Route::post('/get-lobby-url', 'getLobbyUrl')->name('get.lobby.url');
    Route::post('/games/insert', 'insertGames')->name('insertGames');
    Route::post('/games/search', 'searchGame')->name('searchGame');
});

Route::controller(SportsApiController::class)->prefix('sports')->group(function () {
    Route::post('/clientAuthentication', 'ClientAuthentication')->name('ClientAuthentication'); 
    Route::post('/getBalance', 'getBalance')->name('GetBalance');
    Route::post('/placeBet', 'placeBet')->name('PlaceBet');
    Route::post('/cancelPlaceBet', 'CancelBet')->name('CancelPlaceBet');
    Route::post('/marketCancel', 'marketCancel')->name('MarketCancel');
    Route::post('/settleMarket', 'settleMarket')->name('SettleMarket');
    Route::post('/resettle', 'resettle')->name('Resettle');
    Route::post('/cancelSettledMarket', 'cancelSettledMarket')->name('CancelSettledMarket');
    Route::post('/cashout', 'cashout')->name('Cashout');
    Route::post('/cancelCashout', 'cancelCashout')->name('CancelCashout'); 
});