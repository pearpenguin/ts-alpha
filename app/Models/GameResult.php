<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class GameResult extends Model
{
    use HasFactory;

    const RESULT_WIN_USA = '1';
    const RESULT_WIN_USSR = '2';
    const RESULT_TIE = '3';

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

    /**
     * Return the winner's user ID (null if tied)
     *
     * @return integer|null
     */
    public function getWinnerId(): ?int
    {
        switch ($this->game_winner) {
            case self::RESULT_WIN_USA:
                return $this->usa_player_id;
            case self::RESULT_WIN_USSR:
                return $this->ussr_player_id;
        }

        // Tie
        return null;
    }

    /**
     * Return the loser's user ID (null if tied)
     *
     * @return integer|null
     */
    public function getLoserId(): ?int
    {
        switch ($this->game_winner) {
            case self::RESULT_WIN_USA:
                return $this->ussr_player_id;
            case self::RESULT_WIN_USSR:
                return $this->usa_player_id;
        }

        // Tie
        return null;
    }

    /**
     * Returns true if the game was tied
     *
     * @return boolean
     */
    public function isTie(): bool
    {
        return $this->game_winner === self::RESULT_TIE;
    }

    public function isUsaVictory(): bool
    {
        return $this->game_winner === self::RESULT_WIN_USA;
    }
}
