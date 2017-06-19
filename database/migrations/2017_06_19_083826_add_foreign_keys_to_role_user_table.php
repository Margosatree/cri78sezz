<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToRoleUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('role_user', function(Blueprint $table)
		{
			$table->foreign('role_id', 'FK_role_user')->references('id')->on('roles')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('user_id', 'FK_user_organization')->references('id')->on('user_organizations')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('role_user', function(Blueprint $table)
		{
			$table->dropForeign('FK_role_user');
			$table->dropForeign('FK_user_organization');
		});
	}

}
