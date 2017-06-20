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
			$table->string('email', 191)->nullable();
			$table->string('mobile', 191)->nullable();
			$table->string('mobile_otp', 191)->nullable();
			$table->string('email_otp', 191)->nullable();
			$table->string('token', 191)->nullable();
			$table->boolean('is_password_reset')->nullable()->default(0);
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
		Schema::drop('reset_verify');
	}

}
