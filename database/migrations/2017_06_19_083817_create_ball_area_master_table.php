<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBallAreaMasterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ball_area_master', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('parent_id');
			$table->string('name')->nullable();
			$table->string('parent_name')->nullable();
			$table->string('other_type')->nullable();
			$table->unique(['id','parent_id'], 'ball_area_index');
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
		Schema::drop('ball_area_master');
	}

}
