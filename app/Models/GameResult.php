<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class GameResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_type',
        'game_code',
        'usa_player_id',
        'ussr_player_id',
        'reported_at',
        'game_winner',
        'end_turn',
        'end_mode',
        'game_date',
        'video1',
        'video2',
        'video3',
    ];

    protected $casts = [
        'reported_at' => 'datetime',
        'game_date' => 'datetime',
    ];

    public function usaPlayer(): Relation
    {
        return $this->belongsTo(User::class);
    }

    public function ussrPlayer(): Relation
    {
        return $this->belongsTo(User::class);
    }

    public function reporter(): Relation
    {
        return $this->belongsTo(User::class);
    }
}
