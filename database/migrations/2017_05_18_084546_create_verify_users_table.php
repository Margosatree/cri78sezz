<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVerifyUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('verify_users', function(Blueprint $table)
		{
			$table->string('email', 191)->nullable();
			$table->string('mobile', 191)->nullable();
			$table->integer('mobile_otp')->nullable();
			$table->integer('email_otp')->nullable();
			$table->string('token', 191)->nullable();
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
		Schema::drop('verify_users');
	}

}
