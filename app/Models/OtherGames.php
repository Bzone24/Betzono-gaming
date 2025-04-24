<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use App\Constants\Status;
use App\Traits\GlobalStatus; 
class OtherGames extends Model
{
    protected $table = 'other_games';
    use GlobalStatus;
    protected $guarded = ['id'];
}
