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
            $table->increments('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('company_name')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->integer('level')->default(3)->unsigned();
            $table->boolean('status')->default(1);
            $table->string('password')->nullable();
            $table->string('image')->nullable();
            $table->text('address')->nullable();
            $table->integer('company')->nullable()->unsigned();
            $table->string('logo')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('level')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('company')->references('id')->on('users')->onDelete('cascade');
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
