<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserOrganizationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_organizations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_master_id');
			$table->integer('organization_master_id');
			$table->enum('registration_type', array('open','registered'))->nullable();
			$table->date('registration_date')->nullable();
			$table->string('email', 191);
			$table->string('password', 191);
			$table->enum('role', array('admin','organizer','user'));
			$table->string('remember_token', 100)->nullable();
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
		Schema::drop('user_organizations');
	}

}
