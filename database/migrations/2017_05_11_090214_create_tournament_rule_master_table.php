<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTournamentRuleMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tournament_rule_master', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('specification')->nullable();
            $table->string('value')->nullable();
            $table->float('range_from')->nullable();
            $table->float('range_to')->nullable();
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
        Schema::dropIfExists('tournament_rule_master');
    }
}
