<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserMastersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_masters', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('first_name', 191)->nullable();
			$table->string('middle_name', 191)->nullable();
			$table->string('last_name', 191)->nullable();
			$table->date('date_of_birth')->nullable();
			$table->enum('gender', array('male','female','others'))->nullable();
			$table->enum('physically_challenged', array('yes','no'))->nullable();
			$table->string('phone', 191);
			$table->string('email', 191);
			$table->integer('is_verify_phone')->default(0);
			$table->integer('is_verify_email')->default(0);
			$table->string('username', 191)->nullable();
			$table->string('address', 191)->nullable();
			$table->string('suburb', 191)->nullable();
			$table->string('city', 191)->nullable();
			$table->string('state', 191)->nullable();
			$table->string('country', 191)->nullable();
			$table->integer('pin')->nullable();
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
		Schema::drop('user_masters');
	}

}
