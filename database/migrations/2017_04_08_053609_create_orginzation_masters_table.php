<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrginzationMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::create('organization_masters', function (Blueprint $table) {
         $table->increments('id');
         $table->string('name');
         $table->string('address');
         $table->string('landmark')->nullable();
         $table->string('city');
         $table->string('state');
         $table->string('country');
         $table->integer('pincode');
         $table->string('business_type')->nullable();
         $table->string('business_operation');
         $table->string('spoc');
         $table->integer('is_verified');
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
         Schema::dropIfExists('organization_masters');
     }
}
