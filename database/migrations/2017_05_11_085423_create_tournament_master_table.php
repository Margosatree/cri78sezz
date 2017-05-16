<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTournamentMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tournament_master', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tournament_name')->nullable();
            $table->string('tournament_location')->nullable();
            $table->string('tournament_logo')->nullable();
            $table->integer('organization_master_id')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('reg_start_date')->nullable();
            $table->date('reg_end_date')->nullable();
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
        Schema::dropIfExists('tournament_master');
    }
}
