<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCricketProfilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cricket_profiles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_master_id');
			$table->integer('your_role');
			$table->enum('batsman_style', array('Lefthand','Righthand'))->nullable();
			$table->integer('batsman_order')->nullable();
			$table->enum('bowler_style', array('Lefthand','Righthand'))->nullable();
			$table->string('player_type', 191)->nullable();
			$table->string('description', 191)->nullable();
			$table->string('display_img', 191)->nullable();
			$table->integer('is_completed')->nullable();
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
		Schema::drop('cricket_profiles');
	}

}
