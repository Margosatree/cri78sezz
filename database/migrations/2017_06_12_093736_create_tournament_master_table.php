<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTournamentMasterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tournament_master', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('tournament_name', 191)->nullable();
			$table->string('tournament_location', 191)->nullable();
			$table->string('tournament_logo', 191)->nullable();
			$table->integer('organization_master_id')->nullable();
			$table->date('start_date')->nullable();
			$table->date('end_date')->nullable();
			$table->date('reg_start_date')->nullable();
			$table->date('reg_end_date')->nullable();
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
		Schema::drop('tournament_master');
	}

}
