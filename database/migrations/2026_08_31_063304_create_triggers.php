<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        /** On Student adding class schedule trigger
        DB::unprepared("
            CREATE TRIGGER update_class_status AFTER UPDATE ON student_hours 
            FOR EACH ROW BEGIN
                /** After updating the hours_used, retrieve the hours left
                SET @hours_left = (SELECT (hours_enrolled - hours_used) FROM student_hours WHERE student_id = NEW.student_id);

                /** If @hours_left is 0 then update class_status to inactive else active 
                UPDATE student_class_info 
                SET class_status = IF(@hours_left = 0, 'inactive', 'active')
                WHERE student_id = NEW.student_id;
            END
        ");*/

        /***
            NOTE:
            - Always check the foreign keys to determine if the table is a child table or the base table.
            - A row in the base table cannot be deleted without deleting first the related data in the child table.

            TRIGGERS
            - When the student adds a class schedule, the student's class will automatically be determined according to his/her hours_left

        ***/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop created triggers
        //DB::raw('DROP TRIGGER update_class_status');
    }
}
