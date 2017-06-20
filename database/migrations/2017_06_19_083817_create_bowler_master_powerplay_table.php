<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBowlerMasterPowerplayTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bowler_master_powerplay', function(Blueprint $table)
		{
			$table->integer('trans_id', true);
			$table->integer('match_id')->nullable()->index('match_id');
			$table->integer('innings')->nullable()->index('innings');
			$table->integer('order_id')->nullable();
			$table->integer('bowler_id')->nullable()->index('bowler_id');
			$table->string('bolwer_name')->nullable();
			$table->string('bolwer_type')->nullable();
			$table->integer('balls')->nullable();
			$table->float('overs', 10, 1)->nullable();
			$table->integer('maiden')->nullable();
			$table->integer('runs')->nullable();
			$table->integer('run0')->nullable();
			$table->integer('run1')->nullable();
			$table->integer('run2')->nullable();
			$table->integer('run3')->nullable();
			$table->integer('run4')->nullable();
			$table->integer('run6')->nullable();
			$table->integer('run_ext')->nullable();
			$table->integer('run_ext_wd')->nullable();
			$table->integer('run_ext_nb')->nullable();
			$table->integer('caught')->nullable();
			$table->integer('bowled')->nullable();
			$table->integer('hitwicket')->nullable();
			$table->integer('stumping')->nullable();
			$table->integer('lbw')->nullable();
			$table->float('econ', 10)->nullable();
			$table->string('wicket')->nullable();
			$table->integer('index')->nullable();
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
		Schema::drop('bowler_master_powerplay');
	}

}
