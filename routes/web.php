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

Route::get('', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/about-us', [\App\Http\Controllers\HomeController::class, 'about'])->name('about');
Route::get('/instructors', [\App\Http\Controllers\HomeController::class, 'instructors'])->name('instructors');
Route::get('/login', [\App\Http\Controllers\HomeController::class, 'login'])->name('login');
Route::get('/signup', [\App\Http\Controllers\HomeController::class, 'signup'])->name('signup');
Route::post('/login', [\App\Http\Controllers\AccountController::class, 'processLogin']);
Route::post('/instructor-login', [\App\Http\Controllers\AccountController::class, 'processInstructorLogin']);
Route::post('/admin-login', [\App\Http\Controllers\AdminController::class, 'processAdminLogin']);
Route::post('/signup', [\App\Http\Controllers\HomeController::class, 'processSignup']);
Route::get('/forgot-password', [\App\Http\Controllers\HomeController::class, 'forgotPassword']);
Route::get('/user-data', [\App\Http\Controllers\AccountController::class, 'getUserData']);
Route::get('/learning-paths', [\App\Http\Controllers\HomeController::class, 'getLearningPaths']);

Route::prefix('courses')->group(function (){
    Route::get('', [\App\Http\Controllers\HomeController::class, 'courses'])->name('courses');
    Route::get('primary', [\App\Http\Controllers\HomeController::class, 'primaryCourses'])->name('courses.primary');
    Route::get('lower-secondary', [\App\Http\Controllers\HomeController::class, 'lowerSecondaryCourses'])->name('courses.lower-secondary');
    Route::get('upper-secondary', [\App\Http\Controllers\HomeController::class, 'upperSecondaryCourses'])->name('courses.upper-secondary');
});

Route::prefix('admin')->middleware(['ensure.admin'])->group(function () {
    Route::redirect('', 'admin/dashboard');
    Route::get('dashboard', 'HomeController@indexAdmin')->name('admin.dashboard');
    Route::get('courses', 'CoursesController@indexCourses');
    Route::get('courses/{id}', 'CoursesController@showCourse');
    Route::get('courses/{id}/modules', 'CoursesController@courseModules');
    Route::get('courses/{id}/topics', 'CoursesController@courseTopics');
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
});

Route::middleware('ensure.authenticated')->group(function () {
    Route::post('logout', 'AccountController@logout');
    Route::get('zoom-token', 'ClassroomsController@getZoomToken');
    Route::get('zoom-classroom', 'ClassroomsController@zoomClassroom')->name('zoom-classroom');

    Route::prefix('v1')->group(function () {
        Route::get('form-selections-options', 'HomeController@formSelectionsOptions');
        Route::get('my-courses', 'StudentsController@myCourses');
        Route::get('dashboard-statistics', 'AdminController@dashboardStatistics');

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


