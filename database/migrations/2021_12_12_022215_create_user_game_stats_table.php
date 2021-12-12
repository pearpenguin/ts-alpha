<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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

        // Insert a stat row for each existing user
        DB::table('users')->orderBy('id')->each(function ($user) {
            DB::table('user_game_stats')->insert([
                'player_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
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
