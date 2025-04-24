<?php

use Illuminate\Support\Facades\Route;
 
Route::middleware('auth')->name('games.')->group(function () {
    Route::controller('GameController')->group(function () {
        Route::get('play-game/{gameslug}', 'playGame')->name('play-game');
        Route::any('fund-transfer-to-game/{type}/{gameslug}', 'fundTransferToGame')->name('fund-transfer-to-game');
        
        
    });
});