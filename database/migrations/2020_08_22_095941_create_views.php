<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        /** Student Account Info View 
        DB::statement("
            CREATE VIEW v_StudentAccountInfo AS 
            SELECT s.user_id, s.student_id, u.user_name, u.user_pass, ur.user_type, 
            s.email_address, CONCAT(s.firstname, '', s.lastname) AS fullname, s.photo 
            FROM students AS s 
            JOIN users AS u ON (s.user_id = u.user_id)
            JOIN user_type as ur ON (u.role_id = ur.role_id);
        ");

        /** Student Class Info View 
        DB::statement("
            CREATE VIEW v_StudentClassInfo AS
            SELECT sc.student_id AS student_id, c.course_name AS course_name, l.level_name AS level_name,
            sc.lesson_num AS lesson_num, (sh.hours_enrolled - sh.hours_used) AS hours_left, sc.class_status AS class_status, sc.origin AS origin 
            FROM student_class_info sc
            JOIN student_hours sh ON (sc.student_id = sh.student_id) 
            JOIN course c ON (sc.course_id = c.course_id) 
            JOIN level l ON (sc.level_id = l.level_id);
        ");*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop created views and triggers
        //DB::statement('DROP VIEW v_StudentAccountInfo');
        //DB::statement('DROP VIEW v_StudentClassInfo');
    }
}
