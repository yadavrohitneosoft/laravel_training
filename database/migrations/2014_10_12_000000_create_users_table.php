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
            $table->string('firstname', 100);
            $table->string('lastname', 100);
            $table->string('email', 100); 
            $table->enum('user_type', ['1', '2', '3'])->default('3')->comment('1=>Super Admin,2=>Admin,3=>User');
            $table->string('password', 100);
            $table->enum('status', ['0', '1'])->default('0')->comment('0=>Active,1=>InActive');
            $table->rememberToken(); 
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
        Schema::dropIfExists('users');
    }
}
