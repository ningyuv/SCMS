<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (\auth('student')->check() || \auth('teacher')->check() || \auth('admin')->check()){
        return redirect('/home');
    }
    return view('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('/student', 'StudentController');
Route::post('/student/courses/query', 'StudentController@query');
Route::resource('/teacher', 'TeacherController');
Route::resource('/admin', 'AdminController');

Route::get('/login/student', 'Auth\LoginController@showLoginForm');
Route::get('/login/teacher', 'Auth\LoginController@showLoginForm');
Route::get('/login/admin', 'Auth\LoginController@showLoginForm');
Route::get('/register/student', 'Auth\RegisterController@showRegistrationForm');
Route::get('/register/teacher', 'Auth\RegisterController@showRegistrationForm');
Route::get('/register/admin', 'Auth\RegisterController@showRegistrationForm');

Route::post('/login/student', 'Auth\LoginController@login');
Route::post('/login/teacher', 'Auth\LoginController@login');
Route::post('/login/admin', 'Auth\LoginController@login');
Route::post('/register/student', 'Auth\RegisterController@createStudent');
Route::post('/register/teacher', 'Auth\RegisterController@createTeacher');
Route::post('/register/teacher', 'Auth\RegisterController@createAdmin');

