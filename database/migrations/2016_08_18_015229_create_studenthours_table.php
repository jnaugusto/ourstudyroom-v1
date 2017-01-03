<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudenthoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_hours', function (Blueprint $table) {
            $table->increments('student_id');
            $table->foreign('student_id')->references('student_id')->on('students');
            $table->integer('hours_enrolled');
            $table->integer('hours_used');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('student_hours');
    }
}
