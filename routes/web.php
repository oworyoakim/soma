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

use Illuminate\Support\Facades\Route;

Route::get('/login', 'AccountController@login')->name('login');
Route::post('/login', 'AccountController@processLogin')->name('login');

Route::middleware('ensure.authenticated')->group(function () {
    Route::get('', 'HomeController@index')->name('home');
    Route::post('logout', 'AccountController@logout');
    Route::get('user-data', 'AccountController@getUserData');
    Route::get('zoom-token', 'ClassroomsController@getZoomToken');
    Route::get('zoom-classroom', 'ClassroomsController@zoomClassroom')->name('zoom-classroom');

    Route::prefix('v1')->group(function () {
        Route::get('form-selections-options', 'HomeController@formSelectionsOptions');
        Route::get('my-courses', 'StudentsController@myCourses');
        Route::get('my-programs', 'StudentsController@myPrograms');

        // Logbooks
        Route::prefix('logbooks')->group(function () {
            Route::get('', 'LogbooksController@index');
            Route::post('', 'LogbooksController@store');
            Route::put('', 'LogbooksController@update');
            Route::patch('approve', 'LogbooksController@approve');
            Route::patch('decline', 'LogbooksController@decline');
        });

        // Programs
        Route::prefix('programs')->group(function () {
            Route::get('', 'ProgramsController@index');
            Route::get('{id}', 'ProgramsController@show');
            Route::post('', 'ProgramsController@store');
            Route::put('', 'ProgramsController@update');
        });

        // Intakes
        Route::prefix('intakes')->group(function () {
            Route::get('', 'IntakesController@index');
            Route::post('', 'IntakesController@store');
            Route::put('', 'IntakesController@update');
        });

        // Levels
        Route::prefix('levels')->group(function () {
            Route::get('', 'LevelsController@index');
            Route::post('', 'LevelsController@store');
            Route::put('', 'LevelsController@update');
        });

        // Courses
        Route::prefix('courses')->group(function () {
            Route::get('', 'CoursesController@index');
            Route::get('{id}', 'CoursesController@show');
            Route::post('', 'CoursesController@store');
            Route::put('', 'CoursesController@update');
            Route::patch('', 'CoursesController@updateCourseDescription');
        });

        // Modules
        Route::prefix('modules')->group(function () {
            Route::get('', 'ModulesController@index');
            Route::get('{id}', 'ModulesController@show');
            Route::post('', 'ModulesController@store');
            Route::put('', 'ModulesController@update');
        });

        // Topics
        Route::prefix('topics')->group(function () {
            Route::get('', 'TopicsController@index');
            Route::get('{id}', 'TopicsController@show');
            Route::post('', 'TopicsController@store');
            Route::put('', 'TopicsController@update');
        });

        // Classrooms
        Route::prefix('classrooms')->group(function () {
            Route::get('', 'ClassroomsController@index');
            Route::get('{id}', 'ClassroomsController@show');
            Route::post('', 'ClassroomsController@store');
            Route::put('', 'ClassroomsController@update');
        });

        // Questions
        Route::prefix('questions')->group(function () {
            Route::get('', 'QuestionsController@index');
            Route::post('', 'QuestionsController@store');
            Route::put('', 'QuestionsController@update');
        });


        // Answers
        Route::prefix('answers')->group(function () {
            Route::get('', 'AnswersController@index');
            Route::post('', 'AnswersController@store');
            Route::put('', 'AnswersController@update');
        });

        // Students
        Route::prefix('students')->group(function () {
            Route::get('', 'StudentsController@index');
            Route::post('', 'StudentsController@store');
            Route::put('', 'StudentsController@update');
            Route::get('next-id', 'StudentsController@nextId');
            Route::get('{id}', 'StudentsController@show');
        });

        // Enrollments
        Route::group(['prefix' => 'enrollments'], function () {
            Route::get('', 'EnrollmentsController@index');
            Route::post('', 'EnrollmentsController@store');
        });

        // Instructors
        Route::group(['prefix' => 'instructors'], function () {
            Route::get('', 'InstructorsController@index');
            Route::post('', 'InstructorsController@store');
        });

        // Exams
        Route::prefix('exams')->group(function () {
            Route::get('', 'ExamsController@index');
            Route::post('', 'ExamsController@store');
            Route::put('', 'ExamsController@update');
        });

        // Exam
        Route::prefix('exam')->group(function () {
            Route::get('info', 'ExamsController@getExamInfo');
            Route::get('questions', 'ExamsController@getExamQuestions');
            Route::post('responses', 'ExamsController@storeResponses');
        });

        // Users
        Route::prefix('users')->group(function () {
            Route::get('', 'UsersController@index');
            Route::get('{id}', 'UsersController@show');
            Route::post('', 'UsersController@store');
            Route::put('', 'UsersController@update');
        });

        // Roles
        Route::prefix('roles')->group(function () {
            Route::get('', 'RolesController@index');
            Route::post('', 'RolesController@store');
            Route::put('', 'RolesController@update');
            Route::patch('', 'RolesController@updatePermissions');
        });
    });

    Route::prefix('admin')->middleware(['ensure.admin'])->group(function () {
        Route::get('courses', 'CoursesController@indexCourses');
        Route::get('live-classes', 'ClassroomsController@indexClassrooms');
        Route::get('students', 'StudentsController@indexStudents');
        Route::get('instructors', 'InstructorsController@indexInstructors');
        Route::get('users', 'UsersController@indexUsers');
        Route::get('roles', 'RolesController@indexRoles');
        Route::get('levels', 'LevelsController@indexLevels');
        Route::get('intakes', 'IntakesController@indexIntakes');
        Route::get('programs', 'ProgramsController@indexPrograms');
        Route::get('exams', 'ExamsController@indexExams');
        Route::get('enrollments', 'EnrollmentsController@indexEnrollments');
        Route::get('logbooks', 'LogbooksController@indexLogbooks');
        // Dashboard Page
        Route::get('{name?}', 'HomeController@indexAdmin')
             ->name('admin.dashboard')
             ->where('name', '|dashboard');
    });

    Route::prefix('student')->middleware(['ensure.learner'])->group(function () {
        // Home Page
        //Route::get('/', 'HomeController@indexStudent')->name('student.dashboard');

        // My Courses Page
        Route::get('courses', 'HomeController@studentCourses')->name('student.courses');
        // Profile Page
        Route::get('profile', 'HomeController@studentProfile')->name('student.profile');
        // Dashboard Page
        Route::get('{name?}', 'HomeController@indexStudent')
             ->name('student.dashboard')
             ->where('name', '|dashboard');
    });

    //Route::get('{any?}', 'HomeController@index')->where('any', '.+');
});


