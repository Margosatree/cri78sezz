<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserAchievementsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_achievements', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_master_id');
			$table->string('title', 191);
			$table->integer('organization_master_id')->default(0);
			$table->string('location', 191)->nullable();
			$table->date('start_date')->nullable();
			$table->date('end_date')->nullable();
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
		Schema::drop('user_achievements');
	}

}
