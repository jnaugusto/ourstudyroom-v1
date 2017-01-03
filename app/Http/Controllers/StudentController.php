<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\ClassSchedules;
use App\StudentHours;
use Carbon\Carbon;
use App\UserRoles;
use App\Staffs;
use App\User;
use DB;

class StudentController extends Controller
{

    private $response_array = array();

    public function getStudentHour($student_id) {
        $studentHours = StudentHours::where('student_id', '=', $student_id)
                        ->select(DB::raw('hours_enrolled - hours_used AS hours_left'))
                        ->get();
        return response()->json($studentHours);
    }

    public function index() {
        
    }

}
