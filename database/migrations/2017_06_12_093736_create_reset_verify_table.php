<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateResetVerifyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reset_verify', function(Blueprint $table)
		{
			$table->string('email')->nullable();
			$table->string('mobile')->nullable();
			$table->string('mobile_otp')->nullable();
			$table->string('email_otp')->nullable();
			$table->string('token')->nullable();
			$table->boolean('is_password_reset')->nullable()->default(0);
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
		Schema::drop('reset_verify');
	}

}
