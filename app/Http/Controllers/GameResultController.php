<?php

namespace App\Http\Controllers;

use App\Models\GameResult;
use App\Models\User;
use Illuminate\Http\Request;

class GameResultController extends Controller
{
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
     * Store a newly created resource in storage.
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

        $result = new GameResult($inputs);
        // TODO: reporter_id is the user making the request
        $result->reported_at = now();
        $result->save();

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
