<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBallTypeMasterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ball_type_master', function(Blueprint $table)
		{
			$table->integer('trans_id', true);
			$table->string('ball_type', 20)->nullable()->index('ball_type');
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
		Schema::drop('ball_type_master');
	}

}
