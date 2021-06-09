<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->string('name'); 
            $table->string('email')->unique(); 
            $table->enum('role_id', ['1', '2'])->default('2')->comment('1=>Admin,2=>Customer');
            $table->string('image', 100)->nullable(); 
            $table->string('password', 100);
            $table->enum('status', ['0', '1'])->default('1')->comment('1=>Active,0=>InActive');
            $table->rememberToken(); 
            $table->dateTime('created_at', 0)->nullable();
            $table->dateTime('updated_at', 0)->nullable();
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
        Schema::dropIfExists('users');
    }
}
