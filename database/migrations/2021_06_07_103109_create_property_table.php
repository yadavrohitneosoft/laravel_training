<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 100); 
            $table->decimal('price', 8, 2);
            $table->decimal('floor_area', 8, 2);  
            $table->tinyInteger('bedroom');
            $table->tinyInteger('bathroom');
            $table->string('city', 100); 
            $table->text('address');
            $table->text('description');
            $table->string('nearby', 100);
            $table->enum('status', ['0', '1'])->default('1')->comment('1=>Active,0=>InActive');
            $table->dateTime('created_at', 0);
            $table->dateTime('deleted_at', 0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property');
    }
}
