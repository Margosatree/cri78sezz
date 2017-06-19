<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateScoreMasterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('score_master', function(Blueprint $table)
		{
			$table->integer('trans_id', true);
			$table->integer('match_id')->nullable()->index('index_key_val');
			$table->integer('innings')->nullable()->index('innings');
			$table->integer('team_id')->nullable()->index('team_id');
			$table->integer('team_score')->nullable();
			$table->integer('team_wickets')->nullable();
			$table->integer('total_extras')->nullable();
			$table->integer('total_nb')->nullable();
			$table->integer('total_wd')->nullable();
			$table->integer('total_leg_byes')->nullable();
			$table->integer('total_byes')->nullable();
			$table->boolean('toss_won')->nullable();
			$table->text('status', 65535)->nullable();
			$table->float('run_rate', 10, 0)->nullable();
			$table->integer('total_balls')->nullable();
			$table->unique(['match_id','innings','team_id'], 'composite_key_val');
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
		Schema::drop('score_master');
	}

}
