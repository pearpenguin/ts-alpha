<?php

namespace App\Http\Controllers;

use App\Models\GameResult;
use App\Models\User;
use App\Services\RatingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @group Game Results
 */
class GameResultController extends Controller
{
    protected function getRatingService(): RatingService
    {
        return resolve(RatingService::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Record a game result
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->validate([
            'game_type' => 'required|string',
            'game_code' => 'required|string',
            'game_winner' => 'required|string',
            'end_turn' => 'required|numeric|integer',
            'end_mode' => 'required|string',
            'game_date' => 'required|date',
            'usa_player_id' => 'required|exists:users,id',
            'ussr_player_id' => 'required|exists:users,id',
            'video1' => 'url',
            'video2' => 'url',
            'video3' => 'url',
        ]);

        $result = DB::transaction(function () use ($inputs) {
            $result = new GameResult($inputs);
            // TODO: reporter_id is the user making the request
            $result->reported_at = now();
            $result->save();

            // Just update stats synchronously for now
            $this->getRatingService()->updateRatings($result);

            return $result;
        });

        return $this->serializeEntity($result->toArray());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GameResult  $gameResult
     * @return \Illuminate\Http\Response
     */
    public function show(GameResult $gameResult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GameResult  $gameResult
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GameResult $gameResult)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GameResult  $gameResult
     * @return \Illuminate\Http\Response
     */
    public function destroy(GameResult $gameResult)
    {
        //
    }
}
