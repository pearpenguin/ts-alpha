<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings_history', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('player_id');
            $table->foreign('player_id')->references('id')->on('users');
            $table->integer('rating');
            $table->string('game_code');
            $table->unsignedBigInteger('game_result_id');
            $table->foreign('game_result_id')->references('id')->on('game_results');
            $table->integer('total_games');
            $table->integer('friendly_games');
            $table->integer('usa_victories');
            $table->integer('usa_losses');
            $table->integer('usa_ties');
            $table->integer('ussr_victories');
            $table->integer('ussr_losses');
            $table->integer('ussr_ties');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ratings_history');
    }
}
