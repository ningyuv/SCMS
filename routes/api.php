<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:api-student')->get('/user/student', function (Request $request) {
    return $request->user()->with(
        'selectable_courses.course.department',
        'selectable_courses.students',
        'selectable_courses.teacher',
        'selectable_courses.course_type',
        'selectable_courses.arrangements.selectable_course.course',
        'selectable_courses.arrangements.selectable_course.teacher',
        'selectable_courses.arrangements.classroom.building',
        'major'
    )->where('id', $request->user()->id)->first();
});
Route::middleware('auth:api-teacher')->get('/user/teacher', function (Request $request) {
    return $request->user()->with(
        'selectable_courses.course.department',
        'selectable_courses.arrangements.selectable_course.course',
        'selectable_courses.arrangements.classroom.building'
    )->where('id', $request->user()->id)->first();
});
Route::middleware('auth:api-admin')->get('/user/admin', function (Request $request) {
    return $request->user();
});

Route::resource('/course_student', 'CourseStudentController');
Route::resource('/selectable_course', 'SelectableCourseController');
Route::resource('/students', 'StudentsController');
Route::resource('/teachers', 'TeachersController');
Route::resource('/admins', 'AdminsController');
Route::resource('/courses', 'CoursesController');
Route::resource('/arrangements', 'ArrangementsController');
Route::resource('/buildings', 'BuildingsController');
Route::resource('/majors', 'MajorsController');
Route::resource('/departments', 'DepartmentsController');
Route::resource('/classrooms', 'ClassroomsController');
Route::resource('/course_types', 'CourseTypesController');
