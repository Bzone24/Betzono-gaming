<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CasinoGameList extends Model
{
    use HasFactory;

    protected $table = 'casino_game_list'; // Table Name

    protected $primaryKey = 'id'; // Primary Key

    public $timestamps = true; // Enable Timestamps

    protected $fillable = [
        'game_code',
        'game_name',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean', // Cast status as boolean
    ];
}
