<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentclassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_classes_infos', function (Blueprint $table) {
            $table->increments('student_id');
            $table->foreign('student_id')->references('student_id')->on('students');
            $table->integer('course_id')->unsigned();
            $table->foreign('course_id')->references('course_id')->on('courses');
            $table->integer('level_id')->unsigned();
            $table->foreign('level_id')->references('level_id')->on('levels');
            $table->integer('lesson_num')->default('1');
            $table->enum('class_type', ['1:1', '1:4'])->default('1:1');
            $table->boolean('active')->default(true);
            $table->string('origin', 30)->default('direct');
            $table->integer('agent_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('student_classes_infos');
    }
}
