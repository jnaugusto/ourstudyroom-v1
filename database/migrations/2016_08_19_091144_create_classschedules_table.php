<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassschedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_schedules', function (Blueprint $table) {
            $table->increments('class_id');
            $table->integer('staff_id')->unsigned();
            $table->foreign('staff_id')->references('staff_id')->on('staffs');
            $table->dateTime('sched_date');
            $table->enum('class_type', ['1:1', '1:4'])->default('1:1');
            $table->integer('student_id')->nullable();
            $table->boolean('active')->default(true);
        });

        DB::statement(DB::raw('ALTER TABLE class_schedules AUTO_INCREMENT = 100001'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('class_schedules');
    }
}
