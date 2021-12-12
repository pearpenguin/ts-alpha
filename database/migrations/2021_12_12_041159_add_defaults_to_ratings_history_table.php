<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultsToRatingsHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ratings_history', function (Blueprint $table) {
            $table->integer('rating')->default(0)->change();
            $table->integer('total_games')->default(0)->change();
            $table->integer('friendly_games')->default(0)->change();
            $table->integer('usa_victories')->default(0)->change();
            $table->integer('usa_losses')->default(0)->change();
            $table->integer('usa_ties')->default(0)->change();
            $table->integer('ussr_victories')->default(0)->change();
            $table->integer('ussr_losses')->default(0)->change();
            $table->integer('ussr_ties')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ratings_history', function (Blueprint $table) {
            //
        });
    }
}
