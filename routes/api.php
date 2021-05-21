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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// routes for WebCronTaskController
Route::get('/tasks', 'App\Http\Controllers\WebCronTaskController@getTasks');
Route::get('/tasks/{id}', 'App\Http\Controllers\WebCronTaskController@getSingleTask');
Route::post('/tasks', 'App\Http\Controllers\WebCronTaskController@createTask');
Route::delete('/tasks/{id}', 'App\Http\Controllers\WebCronTaskController@deleteTask');
Route::put('/tasks/{id}', 'App\Http\Controllers\WebCronTaskController@updateTask');
Route::patch('/tasks/{id}', 'App\Http\Controllers\WebCronTaskController@partialUpdateTask');

// routes for WebCronResultController
Route::get('/results', 'App\Http\Controllers\WebCronResultController@getResults');
Route::get('/results/{id}', 'App\Http\Controllers\WebCronResultController@getSingleResult');
Route::post('/results', 'App\Http\Controllers\WebCronResultController@createResult');
Route::delete('/results/{id}', 'App\Http\Controllers\WebCronResultController@deleteResult');
Route::put('/results/{id}', 'App\Http\Controllers\WebCronResultController@updateResult');
Route::patch('/results/{id}', 'App\Http\Controllers\WebCronResultController@partialUpdateResult');
