<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;

Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

Route::get('cron', 'CronController@cron')->name('cron');

// Route::get('livecasino', 'SiteController@liveCasino')->name('liveCasino');
Route::get('livecasino', 'SiteController@newfunGame')->name('newfunGame');
Route::get('/games/search', 'SiteController@searchGame')->name('searchGame');
Route::get('/load-more', 'SiteController@loadMore')->name('loadMore');
Route::get('number-result-cron', 'CronController@numberResultCron')->name('number-result-cron');


// User Support Ticket
Route::controller('TicketController')->prefix('ticket')->name('ticket.')->group(function () {
    Route::get('/', 'supportTicket')->name('index');
    Route::get('new', 'openSupportTicket')->name('open');
    Route::post('create', 'storeSupportTicket')->name('store');
    Route::get('view/{ticket}', 'viewTicket')->name('view');
    Route::post('reply/{id}', 'replyTicket')->name('reply');
    Route::post('close/{id}', 'closeTicket')->name('close');
    Route::get('download/{attachment_id}', 'ticketDownload')->name('download');
});

Route::controller('SiteController')->group(function () {
    Route::get('/lottery-home', 'lotteryHome')->name('lottery.home');
    Route::get('/fungame', 'funGame')->name('fun.game');
    Route::get('/get-games', 'getGames')->name('get-games');
    Route::get('/providers/{provider}', 'providerList')->name('provider-list');

    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'contactSubmit');
    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');
    
    Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');
    
    Route::get('/cookie/accept', 'cookieAccept')->name('cookie.accept');
    
    Route::get('blogs', 'blogs')->name('blog');
    Route::get('blog/{slug}', 'blogDetails')->name('blog.details');
    
    Route::get('policy/{slug}', 'policyPages')->name('policy.pages');

    Route::get('placeholder-image/{size}', 'placeholderImage')->name('placeholder.image');
    Route::get('maintenance-mode', 'maintenance')->withoutMiddleware('maintenance')->name('maintenance');
    
    Route::get('lottery', 'lottery')->name('lottery');
    Route::get('details/{id}', 'lotteryDetails')->name('lottery.details');
    Route::post('subscribe', 'subscribe')->name('subscribe');
    
    Route::get('/{slug}', 'pages')->name('pages');
    Route::get('/', 'home')->name('home');
});

Route::controller('User\Auth\LoginController')->group(function () {
    Route::get('/access-account/{id}', 'autoLogin')->name('autoLogin');
});
