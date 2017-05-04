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
        $table->string('first_name')->nullable();
        $table->string('middle_name')->nullable();
        $table->string('last_name')->nullable();
        $table->date('date_of_birth')->nullable();
        $table->enum('gender', ['male', 'female','others'])->nullable();
        $table->enum('physically_challenged', ['yes', 'no'])->nullable();
        $table->string('phone');
        $table->string('email');
        $table->integer('is_verify_phone')->default(0);
        $table->integer('is_verify_email')->default(0);
        $table->string('username')->nullable();
        $table->string('address')->nullable();
        $table->string('suburb')->nullable();
        $table->string('city')->nullable();
        $table->string('state')->nullable();
        $table->string('country')->nullable();
        $table->integer('pin')->nullable();
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
