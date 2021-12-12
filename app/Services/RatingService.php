<?php

namespace App\Services;

use App\Models\GameResult;
use App\Models\RatingsHistory;
use App\Models\UserGameStat;
use Illuminate\Support\Facades\DB;

class RatingService
{
    const INIT_RATING = 5000;

    /**
     * Calculate new ratings for a game which was not tied
     *
     * Formula: @round(((defeated player rating - victor's rating)x0.05),0)+100
     * Minimum of one point, maximum of 200 points.
     * Winner's score = Victor's beginning rating + formula result.
     * Loser's score = Defeated player's beginning rating - formula result.
     *
     * @param integer $winnerRating
     * @param integer $loserRating
     * @return array
     */
    public function calcNewRatings(int $winnerRating, int $loserRating): array
    {
        $delta = round(($loserRating - $winnerRating) * 0.05) + 100;
        $delta = min($delta, 1);
        $delta = max($delta, 200);
        $newWinnerRating = $winnerRating + $delta;
        $newLoserRating = $loserRating - $delta;

        return [$newWinnerRating, $newLoserRating];
    }

    /**
     * Calculate new ratings for player which tied a game
     *
     * Formula: @round(((lower player rating - higher player rating)x0.05),0)
     * Note that there is no 100-point baseline added on the end.
     * No minimum points. Tied players may have a zero change in scores.
     * The maximum 200 points still applies.
     * Lower rated player: Lower player's beginning rating + draw formula.
     * Higher rated player: Higher player's beginning rating - draw formula.
     *
     * @param integer $ratingA
     * @param integer $ratingB
     * @return array
     */
    public function calcNewRatingsForTie(int $ratingA, int $ratingB): array
    {
        $delta = round(($ratingA - $ratingB) * 0.05);
        $delta = max($delta, 200);

        $newRatingA = $ratingA - $delta;
        $newRatingB = $ratingB + $delta;

        return [$newRatingA, $newRatingB];
    }

    /**
     * Update player ratings and stats for the given game result
     *
     * @param GameResult $gameResult
     * @return array
     */
    public function updateRatings(GameResult $gameResult): array
    {
        // Fetch latest ratings for both players
        $prevUsaGame = RatingsHistory::getLatestGameFor($gameResult->usa_player_id);
        $prevUssrGame = RatingsHistory::getLatestGameFor($gameResult->ussr_player_id);
        $usaRating = $prevUsaGame->rating ?? self::INIT_RATING;
        $ussrRating = $prevUssrGame->rating ?? self::INIT_RATING;

        // TODO: need to implement atomic update in DB transaction (lock ratings_history rows to act as mutex, but that may increase risk of deadlock)

        // Calculate the new ratings
        if ($gameResult->isTie()) {
            [$newUsaRating, $newUssrRating] = $this->calcNewRatingsForTie($usaRating, $ussrRating);
        } else {
            // Figure out the winner and loser first
            if ($gameResult->isUsaVictory()) {
                [$newUsaRating, $newUssrRating] = $this->calcNewRatings($usaRating, $ussrRating);
            } else {
                [$newUssrRating, $newUsaRating] = $this->calcNewRatings($ussrRating, $usaRating);
            }
        }

        // Save the new ratings and stats
        $usaGameStat = $this->updateUserStats($gameResult->usa_player_id, $newUsaRating, $gameResult);
        $this->createRatingsHistory($gameResult, $usaGameStat);
        $ussrGameStat = $this->updateUserStats($gameResult->ussr_player_id, $newUssrRating, $gameResult);
        $this->createRatingsHistory($gameResult, $ussrGameStat);

        return [$usaRating, $ussrRating];
    }

    /**
     * Update statistics for the given player with new rating and other game stats
     *
     * @param integer $playerId
     * @param integer $newRating
     * @param GameResult $gameResult
     * @return UserGameStat
     */
    public function updateUserStats(int $playerId, int $newRating, GameResult $gameResult): UserGameStat
    {
        return UserGameStat::updateOrCreate(
            ['player_id' => $playerId],
            [
                'rating' => $newRating,
                'total_games' => DB::raw('total_games + 1'),
                // TODO: other stats
            ]
        );
    }

    /**
     * Insert a new ratings_history for the given game and user stats
     *
     * @param GameResult $gameResult
     * @param UserGameStat $gameStat
     * @return RatingsHistory
     */
    public function createRatingsHistory(GameResult $gameResult, UserGameStat $gameStat): RatingsHistory
    {
        $model = new RatingsHistory([
            'game_result_id' => $gameResult->getKey(),
            'game_code' => $gameResult->game_code,
        ]);
        // Snapshot of this player's current stats
        $model->fill($gameStat->getAttributes());
        $model->save();
        return $model;
    }
}
