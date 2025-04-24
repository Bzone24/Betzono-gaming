<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeBanner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'image_path',
        'link_url',
        'players_count',
        'is_active',
        'sort_order'
    ];

    public static function categories()
    {
        return [
            'trending-sports' => 'Trending Sports',
            'live-casino' => 'Live Casino Tables',
            'casino-tranding' => 'Casino Tranding',
            'fast-games' => 'Fast Games',
            'live-game-bet' => 'Live game bet',
            'casino-slots' => 'Casino Slots'
        ];
    }
}