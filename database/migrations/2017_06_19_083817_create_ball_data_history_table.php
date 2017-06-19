<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBallDataHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ball_data_history', function(Blueprint $table)
		{
			$table->integer('trans_id', true);
			$table->integer('m_trans_id')->nullable();
			$table->integer('match_id')->nullable()->index('match_id');
			$table->integer('team_id1')->nullable()->index('team_id1');
			$table->integer('team_id2')->nullable()->index('team_id2');
			$table->integer('innings')->nullable()->index('innings');
			$table->integer('batsman_id')->nullable()->index('batsman_id');
			$table->integer('batsman_id2')->nullable()->index('batsman_id2');
			$table->integer('bowler_id')->nullable();
			$table->integer('fielder_id')->nullable()->index('fielder_id');
			$table->integer('batsman_score')->nullable();
			$table->integer('bowler_given')->nullable();
			$table->integer('extra_runs')->nullable();
			$table->integer('total_runs')->nullable();
			$table->integer('team_runs')->nullable();
			$table->integer('for_wicket')->nullable()->index('for_wicket');
			$table->integer('ball_no')->nullable();
			$table->integer('ball_type_id')->nullable()->index('ball_type_id');
			$table->string('ball_type')->nullable()->index('ball_type');
			$table->float('over_no', 10, 0)->nullable();
			$table->integer('maiden')->nullable();
			$table->integer('wicket_id')->nullable();
			$table->string('wicket_type')->nullable();
			$table->string('wicket_desc')->nullable();
			$table->integer('ball_length_id')->nullable();
			$table->integer('ball_area_id')->nullable();
			$table->integer('field_type_id')->nullable();
			$table->integer('power_play')->nullable();
			$table->string('remark')->nullable();
			$table->string('commentry')->nullable();
			$table->index(['trans_id','ball_no'], 'trans_id');
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
		Schema::drop('ball_data_history');
	}

}
