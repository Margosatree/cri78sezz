<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTournamentRuleMasterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tournament_rule_master', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 191);
			$table->string('specification', 191)->nullable();
			$table->string('value', 191)->nullable();
			$table->float('range_from')->nullable();
			$table->float('range_to')->nullable();
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
		Schema::drop('tournament_rule_master');
	}

}
