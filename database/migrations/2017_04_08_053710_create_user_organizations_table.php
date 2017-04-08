<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('user_organizations', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('user_master_id');
        $table->integer('organization_master_id');
        $table->enum('registration_type', ['open', 'registered']);
        $table->date('registration_date');
        $table->string('email');
        $table->string('password');
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
      Schema::dropIfExists('user_organizations');
    }
}
