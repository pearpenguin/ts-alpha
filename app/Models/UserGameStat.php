<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class UserGameStat extends Model
{
    use HasFactory;

    protected $primaryKey = 'player_id';

    public $incrementing = false;

    protected $fillable = [
        'player_id',
        'rating',
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
}
