<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_results', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('usa_player_id');
            $table->foreign('usa_player_id')->references('id')->on('users');
            $table->unsignedBigInteger('ussr_player_id');
            $table->foreign('ussr_player_id')->references('id')->on('users');
            $table->string('game_type')->index();
            $table->string('game_code');
            $table->timestamp('reported_at')->index();
            $table->string('game_winner');
            $table->unsignedInteger('end_turn')->nullable()->index();
            $table->string('end_mode')->nullable()->index();
            $table->timestamp('game_date')->index();
            $table->string('video1')->nullable();
            $table->string('video2')->nullable();
            $table->string('video3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_results');
    }
}
