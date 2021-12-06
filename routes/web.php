<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    //redirect to tasks
    return redirect('/tasks');
});

Route::get('/tasks/','TaskController@showTasks');

Route::get('/sort-tasks/','TaskController@sortTasks');

Route::get('/tasks/add','TaskController@showAddTaskPage');
Route::post('/tasks/add','TaskController@addTask');

Route::get('/tasks/edit/{task_id}','TaskController@showEditTaskPage');
Route::post('/tasks/edit/','TaskController@editTask');

Route::get('/tasks/delete/{task_id}','TaskController@deleteTask');
