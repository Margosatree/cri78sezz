<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('user_masters', function (Blueprint $table) {
        $table->increments('id');
        $table->string('first_name');
        $table->string('middle_name');
        $table->string('last_name');
        $table->date('date_of_birth');
        $table->enum('gender', ['male', 'female','others']);
        $table->enum('physically_challenged', ['yes', 'no']);
        $table->string('phone');
        $table->string('email');
        $table->integer('is_verify_phone');
        $table->integer('is_verify_email');
        $table->string('username');
        $table->string('address');
        $table->string('suburb');
        $table->string('city');
        $table->string('state');
        $table->string('country');
        $table->integer('pin');
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
        Schema::dropIfExists('user_masters');
    }
}
