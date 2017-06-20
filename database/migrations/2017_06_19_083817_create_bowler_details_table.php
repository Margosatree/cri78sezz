<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBowlerDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bowler_details', function(Blueprint $table)
		{
			$table->integer('match_id')->nullable()->index('match_id');
			$table->integer('innings')->nullable()->index('innings');
			$table->integer('bowler_id')->nullable()->index('bowler_id');
			$table->integer('run_given')->nullable();
			$table->integer('ball_count')->nullable();
			$table->integer('ball_area_id')->nullable()->index('ball_area_id');
			$table->string('ball_area')->nullable();
			$table->string('type')->nullable();
			$table->string('other')->nullable();
			$table->string('remark')->nullable();
			$table->unique(['match_id','innings','bowler_id','ball_area_id'], 'bowler_details_composite');
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
		Schema::drop('bowler_details');
	}

}
