<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFielderMasterPowerplayTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fielder_master_powerplay', function(Blueprint $table)
		{
			$table->integer('trans_id', true);
			$table->integer('fielder_id')->nullable()->index('fielder_id');
			$table->string('fielder_name', 50)->nullable();
			$table->integer('innings')->nullable()->index('innings');
			$table->integer('match_id')->nullable()->index('match_id');
			$table->integer('team_id')->nullable();
			$table->integer('caught')->nullable();
			$table->integer('stumping')->nullable();
			$table->integer('run_out')->nullable();
			$table->integer('drop_catch')->nullable();
			$table->integer('misfield')->nullable();
			$table->integer('over_throw')->nullable();
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
		Schema::drop('fielder_master_powerplay');
	}

}
