<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentschedlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::create('student_sched_logs', function (Blueprint $table) {
            $table->increments('log_id');
            $table->integer('student_id')->unsigned();
            $table->integer('sched_id')->unsigned();
            $table->foreign('sched_id')->references('sched_id')->on('class_schedule');
            $table->timestamp('created_at');
            $table->string('status', 15);
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::drop('student_sched_logs');
    }
}
