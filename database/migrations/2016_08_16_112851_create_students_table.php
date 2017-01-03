<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('student_id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->string('firstname', 30);
            $table->string('lastname', 30);
            $table->string('nickname', 30)->nullable();
            $table->date('birthdate')->nullable();
            $table->string('language', 30)->nullable();
            $table->string('country', 30)->nullable();
            $table->string('contact', 30)->nullable();
            $table->string('photo', 100)->default('default.png');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('students');
    }
}
