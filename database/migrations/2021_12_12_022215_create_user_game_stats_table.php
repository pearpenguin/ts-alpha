<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserGameStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_game_stats', function (Blueprint $table) {
            $table->unsignedBigInteger('player_id')->primary();
            $table->foreign('player_id')->references('id')->on('users');
            $table->timestamps();
            $table->integer('rating')->default(5000);
            $table->integer('total_games')->default(0);
            $table->integer('friendly_games')->default(0);
            $table->integer('usa_victories')->default(0);
            $table->integer('usa_losses')->default(0);
            $table->integer('usa_ties')->default(0);
            $table->integer('ussr_victories')->default(0);
            $table->integer('ussr_losses')->default(0);
            $table->integer('ussr_ties')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_game_stats');
    }
}
