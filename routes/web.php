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
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::group(['middleware' => 'auth'], function () {
    // Route::resource('tasks', \App\Http\Controllers\TasksController::class);

    Route::patch('webcrontasks/changetaskenabled/{webcrontask}', 'App\Http\Controllers\WebCronTaskController@changeTaskEnabled')->name('webcrontasks.changetaskenabled');
    //Route::patch('webcrontasks/duplicatetask/{webcrontask}', 'App\Http\Controllers\WebCronTaskController@duplicateTask')->name('webcrontasks.duplicatetask');

    Route::resource('webcrontasks', \App\Http\Controllers\WebCronTaskController::class);

    Route::get('webcronresults/sendresultemailbyid/{webcronresult}', 'App\Http\Controllers\WebCronResultController@sendResultEmailById')->name('webcronresults.sendresultemailbyid');
    Route::resource('webcronresults', \App\Http\Controllers\WebCronResultController::class);

    Route::resource('users', \App\Http\Controllers\UsersController::class);
});

//move in route group auth
Route::get('mail/result/{id}', 'App\Http\Controllers\ResultMailController@sendResult');
