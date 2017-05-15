<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_master', function (Blueprint $table) {
            $table->increments('id');
            $table->string('team_name')->nullable();
            $table->integer('team_owner_id')->nullable();
            $table->string('team_type')->nullable();
            $table->string('team_logo')->nullable();
            $table->integer('order_id')->nullable();
            $table->integer('owner_id')->nullable();
            $table->timestamps();
//            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_master');
    }
}
