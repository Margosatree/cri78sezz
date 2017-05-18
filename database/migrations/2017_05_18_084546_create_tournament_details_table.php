<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTournamentDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tournament_details', function(Blueprint $table)
		{
			$table->integer('tournament_id');
			$table->integer('rule_id');
			$table->string('specification', 191)->nullable();
			$table->string('value', 191)->nullable();
			$table->float('range_from')->nullable();
			$table->float('range_to')->nullable();
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
		Schema::drop('tournament_details');
	}

}
