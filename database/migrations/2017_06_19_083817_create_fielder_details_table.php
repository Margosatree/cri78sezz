<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFielderDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fielder_details', function(Blueprint $table)
		{
			$table->integer('match_id')->nullable()->index('match_id');
			$table->integer('innings')->nullable()->index('innings');
			$table->integer('fielder_id')->nullable()->index('fielder_id');
			$table->integer('run_count')->nullable();
			$table->integer('catch')->nullable();
			$table->integer('run_out')->nullable();
			$table->integer('drop_catch')->nullable();
			$table->integer('field_count')->nullable();
			$table->integer('misfield_count')->nullable();
			$table->integer('ball_area_id')->nullable()->index('ball_area_id');
			$table->string('ball_area')->nullable();
			$table->string('type')->nullable();
			$table->string('other')->nullable();
			$table->string('remark')->nullable();
			$table->unique(['match_id','innings','fielder_id','ball_area_id'], 'fielder_det_composite');
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
		Schema::drop('fielder_details');
	}

}
