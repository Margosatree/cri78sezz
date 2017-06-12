<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTeamMasterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('team_master', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('team_name', 191)->nullable();
			$table->integer('team_owner_id')->nullable();
			$table->string('team_type', 191)->nullable();
			$table->string('team_logo', 191)->nullable();
			$table->integer('order_id')->nullable();
			$table->integer('owner_id')->nullable();
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
		Schema::drop('team_master');
	}

}
