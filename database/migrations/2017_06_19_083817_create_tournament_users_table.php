<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTournamentUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tournament_users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('tour_id');
			$table->integer('user_id');
            $table->integer('deleted_by')->nullable();
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
		Schema::drop('tournament_users');
	}

}
