<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBatsmanMasterPowerplayTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('batsman_master_powerplay', function(Blueprint $table)
		{
			$table->integer('trans_id', true);
			$table->integer('match_id')->nullable()->index('match_id');
			$table->integer('order_id')->nullable()->index('order_id');
			$table->integer('innings')->nullable()->index('innings');
			$table->integer('batsman_id')->nullable()->index('batsman_id');
			$table->string('batsman_name')->nullable();
			$table->string('batsman_type')->nullable();
			$table->integer('balls')->nullable();
			$table->integer('runs')->nullable();
			$table->integer('run0')->nullable();
			$table->integer('run1')->nullable();
			$table->integer('run2')->nullable();
			$table->integer('run3')->nullable();
			$table->integer('run4')->nullable();
			$table->integer('run6')->nullable();
			$table->integer('run_ext')->nullable();
			$table->float('strike_rate', 10)->nullable();
			$table->integer('bowler_id')->nullable();
			$table->integer('fielder_id')->nullable();
			$table->string('wicket_type')->nullable();
			$table->integer('ball_length_id')->nullable();
			$table->integer('area_id')->nullable();
			$table->string('out')->nullable();
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
		Schema::drop('batsman_master_powerplay');
	}

}
