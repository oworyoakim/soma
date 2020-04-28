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
    Route::get('user-data', 'AccountController@getUserData')->name('user-data');
    Route::post('logout', 'AccountController@logout')->name('logout');
    // Exam
    Route::get('exam/{courseSlug}', 'HomeController@takeExam')->name('take-exam');

    Route::group(['prefix' => 'v1'], function () {
        // Course
        Route::group(['prefix' => 'courses'], function () {
            Route::get('', 'CoursesController@index')->name('courses');
            Route::post('', 'CoursesController@store')->name('courses');
            Route::put('', 'CoursesController@update')->name('courses');
        });

        // Module
        Route::group(['prefix' => 'modules'], function () {
            Route::get('', 'ModulesController@index')->name('modules');
            Route::post('', 'ModulesController@store')->name('modules');
            Route::put('', 'ModulesController@update')->name('modules');
        });

        // Topic
        Route::group(['prefix' => 'topics'], function () {
            Route::get('', 'TopicsController@index')->name('topics');
            Route::post('', 'TopicsController@store')->name('topics');
            Route::put('', 'TopicsController@update')->name('topics');
        });

        // Question
        Route::group(['prefix' => 'questions'], function () {
            Route::get('', 'QuestionsController@index')->name('questions');
            Route::post('', 'QuestionsController@store')->name('questions');
            Route::put('', 'QuestionsController@update')->name('questions');
        });


        // Answer
        Route::group(['prefix' => 'answers'], function () {
            Route::get('', 'AnswersController@index')->name('answers');
            Route::post('', 'AnswersController@store')->name('answers');
            Route::put('', 'AnswersController@update')->name('answers');
        });

        // Exams
        Route::group(['prefix' => 'exams'], function () {
            Route::get('', 'ExamsController@index')->name('exams');
            Route::post('', 'ExamsController@store')->name('exams');
            Route::put('', 'ExamsController@update')->name('exams');
        });

        // Exam
        Route::group(['prefix' => 'exam'], function () {
            Route::get('info', 'ExamsController@getExamInfo')->name('exam-info');
            Route::post('', 'ExamsController@storeResponses')->name('exam-response');
        });

        // Users
        Route::group(['prefix' => 'users'], function () {
            Route::get('', 'UsersController@index')->name('users');
            Route::post('', 'UsersController@store')->name('users');
            Route::put('', 'UsersController@update')->name('users');
        });

        // Roles
        Route::group(['prefix' => 'roles'], function () {
            Route::get('', 'RolesController@index')->name('roles');
            Route::post('', 'RolesController@store')->name('roles');
            Route::put('', 'RolesController@update')->name('roles');
            Route::patch('', 'RolesController@updatePermissions')->name('roles');
        });

    });

    Route::get('{any?}', 'HomeController@index')->where('any', '.+');
});


