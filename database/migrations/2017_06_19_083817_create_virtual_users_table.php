<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVirtualUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('virtual_users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('phone', 191);
			$table->string('email', 191);
			$table->string('username', 191)->nullable();
			$table->string('password', 191);
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
		Schema::drop('virtual_users');
	}

}
