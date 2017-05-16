<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTournamentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tournament_details', function (Blueprint $table) {
//            $table->increments('id');
            $table->integer('tournament_id');
            $table->integer('rule_id');
            $table->string('specification')->nullable();
            $table->string('value')->nullable();
            $table->float('range_from')->nullable();
            $table->float('range_to')->nullable();
            $table->timestamps();
//            $table->primary(array('tournament_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tournament_details');
    }
}
