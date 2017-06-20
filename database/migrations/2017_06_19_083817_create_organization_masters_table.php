<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrganizationMastersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('organization_masters', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 191);
			$table->string('address', 191);
			$table->string('landmark', 191)->nullable();
			$table->string('city', 191);
			$table->string('state', 191);
			$table->string('country', 191);
			$table->integer('pincode');
			$table->string('business_type', 191)->nullable();
			$table->string('business_operation', 191);
			$table->string('spoc', 191);
			$table->integer('is_verified');
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
		Schema::drop('organization_masters');
	}

}
