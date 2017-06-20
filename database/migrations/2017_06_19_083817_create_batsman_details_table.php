<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBatsmanDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('batsman_details', function(Blueprint $table)
		{
			$table->integer('match_id')->nullable()->index('bat_det_index');
			$table->integer('innings')->nullable()->index('innings');
			$table->integer('order_id')->nullable();
			$table->integer('batsman_id')->nullable()->index('batsman_id');
			$table->integer('run_score')->nullable();
			$table->integer('shot_count')->nullable();
			$table->integer('ball_area_id')->nullable()->index('ball_area_id');
			$table->string('ball_area')->nullable();
			$table->string('type')->nullable();
			$table->string('other')->nullable();
			$table->string('remark')->nullable();
			$table->unique(['match_id','innings','batsman_id','ball_area_id'], 'bat_det_composite');
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
		Schema::drop('batsman_details');
	}

}
