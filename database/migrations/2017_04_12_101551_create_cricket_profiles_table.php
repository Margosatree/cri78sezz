<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCricketProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cricket_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_master_id');
            $table->integer('your_role')->default(null);
            $table->enum('batsman_style', ['Lefthand', 'Righthand'])->nullable();
            $table->integer('batsman_order')->nullable();
            $table->enum('bowler_style', ['Lefthand', 'Righthand'])->nullable();
            $table->string('player_type')->nullable();
            $table->string('description')->nullable();
            $table->string('display_img')->nullable();
            $table->integer('is_completed')->nullable();
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
        Schema::dropIfExists('cricket_profiles');
    }
}
