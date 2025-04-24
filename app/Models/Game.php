<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $table = 'games'; // Specify table name (optional)

    protected $fillable = [
        'game_code',
        'game_name',
        'table_name',
        'table_code',
        'image_url',
        'type',
    ];

    protected $attributes = [
        'type' => 'default' // Set a meaningful default
    ];
}
