<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class RatingsHistory extends Model
{
    use HasFactory;

    protected $table = 'ratings_history';

    protected $fillable = [
        'player_id',
        'rating',
        'game_code',
        'game_result_id',
        'total_games',
        'friendly_games',
        'usa_victories',
        'usa_losses',
        'usa_ties',
        'ussr_victories',
        'ussr_losses',
        'ussr_ties',
    ];

    public function player(): Relation
    {
        return $this->belongsTo(User::class);
    }

    public function gameResult(): Relation
    {
        return $this->belongsTo(GameResult::class);
    }

    public static function getLatestGameFor(int $playerId): ?self
    {
        return self::query()
            ->where('player_id', $playerId)
            ->orderBy('created_at', 'desc')
            ->first();
    }
}
