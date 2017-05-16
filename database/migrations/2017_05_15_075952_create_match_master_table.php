<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('match_master', function(Blueprint $table){
            $table->increments('match_id');
            $table->integer('tournament_id')->nullable();
            $table->integer('team1_id')->nullable();
            $table->integer('team2_id')->nullable();
            $table->string('match_name')->nullable();
            $table->string('ground_name')->nullable();
            $table->string('match_type')->nullable();
            $table->integer('overs')->nullable();
            $table->integer('innings')->nullable();
            $table->string('status')->nullable();
            $table->string('toss')->nullable();
            $table->string('location')->nullable();
            $table->dateTime('match_date')->nullable();
            $table->integer('ttl_overs')->nullable();
            $table->integer('ttl_player_each_cnt')->nullable();
            $table->integer('win_toss_id')->nullable();
            $table->enum('selected_to_by_toss_winner', array('bat','ball'))->nullable();
            $table->integer('inning_1')->nullable();
            $table->integer('inning_2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('match_master');
    }
}
