<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMatchMasterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('match_master', function(Blueprint $table)
		{
			$table->increments('match_id');
			$table->integer('tournament_id')->nullable();
			$table->integer('team1_id')->nullable();
			$table->integer('team2_id')->nullable();
			$table->string('match_name', 191)->nullable();
			$table->string('ground_name', 191)->nullable();
			$table->string('match_type', 191)->nullable();
			$table->integer('overs')->nullable();
			$table->integer('innings')->nullable();
			$table->string('status', 191)->nullable();
			$table->string('toss', 191)->nullable();
			$table->string('location', 191)->nullable();
			$table->dateTime('match_date')->nullable();
			$table->integer('ttl_overs')->nullable();
			$table->integer('ttl_player_each_cnt')->nullable();
			$table->integer('win_toss_id')->nullable();
			$table->enum('selected_to_by_toss_winner', array('bat','ball'))->nullable();
			$table->integer('inning_1')->nullable();
			$table->integer('inning_2')->nullable();
			$table->integer('deleted_by')->nullable();
			$table->integer('updated_by')->nullable();
			$table->softDeletes();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('match_master');
	}

}
