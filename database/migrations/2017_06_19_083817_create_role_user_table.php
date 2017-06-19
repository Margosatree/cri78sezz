<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRoleUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('role_user', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('role_id')->unsigned()->index();
			$table->integer('user_id')->unsigned()->index();
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
		Schema::drop('role_user');
	}

}
