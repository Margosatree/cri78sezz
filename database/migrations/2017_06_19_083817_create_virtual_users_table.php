<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVirtualUsersTable extends Migration {

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
                $table->integer('expected_role_id')->nullable();
                $table->integer('created_by')->nullable();
                $table->string('add_prifix', 191)->nullable();
                $table->integer('prifix_id')->nullable();
                $table->integer('org_id')->nullable();
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
