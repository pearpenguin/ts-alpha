<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReporterIdToGameResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_results', function (Blueprint $table) {
            $table->unsignedBigInteger('reporter_id')->nullable();
            $table->foreign('reporter_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_results', function (Blueprint $table) {
            $table->dropForeign(['reporter_id']);
            $table->dropColumn('reporter_id');
        });
    }
}
