<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFallOfWicketsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fall_of_wickets', function(Blueprint $table)
		{
			$table->integer('match_id')->nullable()->index('FOW_index');
			$table->integer('innings')->nullable()->index('innings');
			$table->integer('team_id')->nullable()->index('team_id');
			$table->string('wicket')->nullable();
			$table->integer('score')->nullable();
			$table->float('over', 10, 0)->nullable();
			$table->integer('batsman_id')->index('batsman_id');
			$table->unique(['match_id','innings','team_id','batsman_id'], 'FOW_key');
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
		Schema::drop('fall_of_wickets');
	}

}
