<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();
Route::get('/', 'Auth\LoginController@showLoginForm');

Route::get('/home', 'HomeController@index');

Route::get('/welcome', function() {
	return view('welcome');
});

Route::get('/test', function() {
	return App\User::create([
            'username' => 'jessnoel',
            'password' => bcrypt('friendly1'),
            'role_id' => 1,
            'email' => 'jessnoelaugusto@gmail.com'
        ]);
});

/*
|--------------------------------------------------------------------------
| Administrator Routes
|--------------------------------------------------------------------------
*/
Route::get('admin/list/{rows}', ['as' => 'admin.getAdminList', 'uses' => 'AdminController@getAdminList']);
Route::resource('admin', 'AdminController');

/*
|--------------------------------------------------------------------------
| Academics Routes
|--------------------------------------------------------------------------
*/
Route::get('acad/list/{rows}', ['as' => 'acad.getAcadList', 'uses' => 'AcadController@getAcadList']);
Route::resource('acad', 'AcadController');

/*
|--------------------------------------------------------------------------
| Student Routes
|--------------------------------------------------------------------------
*/
Route::get('student/gethours/{student_id}', ['as' => 'student.getStudentHour', 'uses' => 'StudentController@getStudentHour']);
Route::resource('student', 'StudentController');

/*
|--------------------------------------------------------------------------
| Classes Routes
|--------------------------------------------------------------------------
*/
Route::get('classes/events/{date}', ['as' => 'classes.getEvents', 'uses' => 'ClassesController@getEvents']);
Route::get('classes/list/students/get', ['as' => 'classes.getStudents', 'uses' => 'ClassesController@getStudents']);
Route::get('classes/list/students/gethours/{student_id}', ['as' => 'classes.getStudentHour', 'uses' => 'ClassesController@getStudentHour']);
Route::resource('classes', 'ClassesController');

