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
Route::get('/', 'TaskController@index')->name('task.index');
Route::post('/new-task', 'TaskController@newTask')->name('task.new');
Route::post('/cancel-task/{task}', 'TaskController@cancelTask')->name('task.cancel');