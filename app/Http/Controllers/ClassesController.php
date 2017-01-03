<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\ClassSchedules;
use App\StudentClasses;
use App\StudentHours;
use Carbon\Carbon;
use App\UserRoles;
use App\Staffs;
use App\User;
use DB;

class ClassesController extends Controller
{

    private $response_array = array();

    public function getEvents($date) {
    	  $events = ClassSchedules::with(['staffs', 'students', 'students.student_class', 'students.student_class.course', 'students.student_class.level'])
    			->where('sched_date', '>=', $date)
    			->get();
        return response()->json($events);
    }

    public function getStudents() {
        $user = User::with(['students', 'roles'])
                ->where('role_id', 4)
                ->orderBy('user_id', 'desc')
                ->get();
        return response()->json($user);
    }

    public function getStudentHour($student_id) {
        $studentHours = StudentHours::where('student_id', '=', $student_id)
                        ->select(DB::raw('hours_enrolled - hours_used AS hours_left'))
                        ->get();
        return response()->json($studentHours);
    }

    public function index() {
        $user = User::with(['staffs', 'roles'])
                ->whereIn('role_id', [2,3])
                ->orderBy('active', 'desc')
                ->orderBy('user_id', 'desc')
                ->get();

        return response()->json($user);
    }

    public function store(Request $request)
    {
        /**
         * Classes Transaction
         */
        try {
            if($request->data['student_id'] != 0) {
                $studentRemainHours = StudentHours::where('student_id', '=', $request->data['student_id'])
                        ->select(DB::raw('hours_enrolled - hours_used AS hours_left'))
                        ->get();
                if($studentRemainHours[0]->hours_left > 0) {
                    $student_hours = StudentHours::find($request->data['student_id']);
                    $student_hours->hours_used = $student_hours->hours_used + 1;
                    $student_hours->save();
                } else return 'nohours';
            }

            $class = new ClassSchedules();
            $class->staff_id = $request->data['teacher_id'];
            $class->sched_date = $request->data['sched_date'];
            $class->class_type = $request->data['class_type'];
            if($request->data['student_id'] != 0) $class->student_id = $request->data['student_id'];
            $class->save();

            return 'success';
        } catch(\Exception $e) {
            return 'failed';
        }
    }

    public function update(Request $request, $class_id)
    {
        // Class Schedule instance
        $class = ClassSchedules::where('class_id', $class_id)->first();

        /**
         * Class Schedule Transaction
         */
        try {

            if($request->data['student_id'] != null && $request->data['student_id'] != 0) {
                $studentRemainHours = StudentHours::where('student_id', '=', $request->data['student_id'])
                        ->select(DB::raw('hours_enrolled - hours_used AS hours_left'))
                        ->get();
                if($studentRemainHours[0]->hours_left == 0) return 'nohours';
            }

            $class->staff_id = $request->data['staff_id'];
            $class->sched_date = $request->data['sched_date'];
            $class->class_type = $request->data['class_type'];
            $class->student_id = ($request->data['student_id'] == null)?null:$request->data['student_id'];
            $class->save();

            if($request->data['past_student_id'] != null) {
                $past_student_hours = StudentHours::find($request->data['past_student_id']);
                $past_student_hours->hours_used = $past_student_hours->hours_used - 1;
                $past_student_hours->save();
            }

            if($request->data['allowHourUpdate'] && $request->data['student_id'] != null) {
                $student_hours = StudentHours::find($request->data['student_id']);
                $student_hours->hours_used = $student_hours->hours_used + 1;
                $student_hours->save();
            }

            $response_array['icon'] = 'check green';
            $response_array['header'] = 'Update Class Schedule';
            $response_array['body'] = 'Class succesfully updated!';
        } catch(\Exception $e) {
            $response_array['icon'] = 'remove red';
            $response_array['header'] = 'Update Class Schedule';
            $response_array['body'] = 'Class update failed!';
        }

        return response()->json($response_array);
    }

    public function destroy($class_student_id)
    {
        // Start transaction!
        DB::beginTransaction();

        try {
            $class_id = explode("_", $class_student_id)[0];
            $student_id = explode("_", $class_student_id)[1];

            ClassSchedules::destroy($class_id);

            if($student_id != 'null') {
                $student_hours = StudentHours::find($student_id);
                $student_hours->hours_used = $student_hours->hours_used - 1;
                $student_hours->save();
            }

            $response_array['icon'] = 'check green';
            $response_array['header'] = 'Delete Class Schedule';
            $response_array['body'] = 'Class succesfully deleted!';

        } catch(\Exception $e) {
            DB::rollback();
            $response_array['icon'] = 'remove red';
            $response_array['header'] = 'Delete Class Schedule';
            $response_array['body'] = 'Class delete failed!'. $e;
        }

        // Continue query execution
        DB::commit();

        return response()->json($response_array);
    }

}
