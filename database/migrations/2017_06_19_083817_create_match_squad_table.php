<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMatchSquadTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('match_squad', function(Blueprint $table)
		{
			$table->integer('tournament_id')->nullable();
			$table->integer('team_id')->nullable();
			$table->integer('match_id')->nullable();
			$table->integer('player_id')->nullable();
			$table->string('playing')->nullable();
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
		Schema::drop('match_squad');
	}

}
