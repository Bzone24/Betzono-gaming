<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use App\Lib\CurlRequest;
use App\Lib\FileManager;
use App\Models\UpdateLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laramin\Utility\VugiChugi;
use App\Models\OtherGames;

class GameController extends Controller
{
  

    public function gameList(){
        $pageTitle = 'Other Games';
        $gameList = OtherGames::all();
        return view('admin.games.list',compact('gameList', 'pageTitle'));
    }
    public function status($id)
    {
        return OtherGames::changeStatus($id);
    }
}
