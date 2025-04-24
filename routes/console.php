<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Artisan::command('clear-session',function(){
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('sessions')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    echo "done";
});

Artisan::command('clear-sharing-token',function(){
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('sharing_user_tokens')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    echo "done";
});

