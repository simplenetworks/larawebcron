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

    Route::patch('webcrontasks/changetaskenabled/{webcrontask}', 'App\Http\Controllers\WebCronTaskController@changeTaskEnabled')->name('webcrontasks.changetaskenabled');
    Route::patch('webcrontasks/duplicatetask/{webcrontask}', 'App\Http\Controllers\WebCronTaskController@duplicateTask')->name('webcrontasks.duplicatetask');
    Route::get('webcrontasks/search', 'App\Http\Controllers\WebCronTaskController@search')->name('webcrontasks.search');
    Route::get('webcrontasks/jsontaskandresultsdownload/{webcrontask}', 'App\Http\Controllers\WebCronTaskController@jsonTaskAndResultsDownload')->name('webcrontasks.jsontaskandresultsdownload');
    Route::get('webcrontasks/jsontasksdownload', 'App\Http\Controllers\WebCronTaskController@jsonTasksDownload')->name('webcrontasks.jsontasksdownload');

    Route::resource('webcrontasks', \App\Http\Controllers\WebCronTaskController::class);

    Route::get('webcronresults/sendresultemailbyid/{webcronresult}', 'App\Http\Controllers\WebCronResultController@sendResultEmailById')->name('webcronresults.sendresultemailbyid');
    Route::get('webcronresults/search', 'App\Http\Controllers\WebCronResultController@search')->name('webcronresults.search');
    Route::get('webcronresults/showbodyresult/{webcronresult}', 'App\Http\Controllers\WebCronResultController@showBodyResult')->name('webcronresults.showbodyresult');
    Route::get('webcronresults/jsonresultdownload/{webcronresult}', 'App\Http\Controllers\WebCronResultController@jsonResultDownload')->name('webcronresults.jsonresultdownload');
    Route::get('webcronresults/jsonresultsdownload', 'App\Http\Controllers\WebCronResultController@jsonResultsDownload')->name('webcronresults.jsonresultsdownload');

    Route::resource('webcronresults', \App\Http\Controllers\WebCronResultController::class);

    Route::resource('users', \App\Http\Controllers\UsersController::class);

    Route::get('mail/result/{id}', 'App\Http\Controllers\ResultMailController@sendResult');

});


