<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\WebCronTask;
use Illuminate\Support\Facades\Validator;

class WebCronTaskController extends Controller
{
    // Route::get('/tasks', 'App\Http\Controllers\WebCronTaskController@getTasks');
    public function getTasks() {
        
        $webCronTasks = WebCronTask::get();
        return response()->json($webCronTasks, 200);

    }

    // Route::get('/tasks/{id}', 'App\Http\Controllers\WebCronTaskController@getSingleTask');
    public function getSingleTask($id) {

        $webCronTask = WebCronTask::with('webCronResults')->findOrFail($id);
        return response()->json($webCronTask, 200);

    }

    // Route::post('/tasks', 'App\Http\Controllers\WebCronTaskController@createTask');
    public function createTask(Request $request) {
       
        $validator = Validator::make($request->all(), [
            'url' => 'required|max:255',
            //'schedule' => 'required|max:255',
            'schedule' =>array('required','max:255','regex:/(@(annually|yearly|monthly|weekly|daily|hourly|reboot))|(@every (\d+(ns|us|µs|ms|s|m|h))+)|((((\d+,)+\d+|(\d+(\/|-)\d+)|\d+|\*) ?){5,7})/'),
            'timeout' => 'required|integer', //default 60
            'attempts' => 'required|integer', //default 1
            'retry_waits' => 'required|integer', //default 5000
            'name' => 'nullable|max:255',
            'site' => 'nullable|max:255',
            'email' => 'nullable|email|max:255',
            'log_type' => 'required|integer', //default 0
            'status' => 'required|integer', //default 0
            'enabled' => 'required|boolean', //default 0
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date'
        ]);

        if($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        $webCronTask = new WebCronTask();
        $webCronTask->url = $request->input('url');
        $webCronTask->schedule = $request->input('schedule'); 
        $webCronTask->timeout = $request->input('timeout'); 
        $webCronTask->attempts = $request->input('attempts'); 
        $webCronTask->retry_waits = $request->input('retry_waits'); 
        $webCronTask->name = $request->input('name'); 
        $webCronTask->site = $request->input('site'); 
        $webCronTask->email = $request->input('email'); 
        $webCronTask->log_type = $request->input('log_type'); 
        $webCronTask->status = $request->input('status'); 
        $webCronTask->enabled = $request->input('enabled'); 
        $webCronTask->start_date = $request->input('start_date'); 
        $webCronTask->end_date = $request->input('end_date');
        $webCronTask->save();

        return response()->json($webCronTask, 201);
    }

    // Route::delete('/tasks/{id}', 'App\Http\Controllers\WebCronTaskController@deleteTask');
    public function deleteTask($id) {
        $webCronTask = WebCronTask::findOrFail($id);
        $webCronTask->delete();

        return response()->json(null, 204);
    }

    // Route::put('/tasks/{id}', 'App\Http\Controllers\WebCronTaskController@updateTask');
    public function updateTask(Request $request, $id) {
        $webCronTask = WebCronTask::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'url' => 'required|max:255',
            'schedule' =>array('required','max:255','regex:/(@(annually|yearly|monthly|weekly|daily|hourly|reboot))|(@every (\d+(ns|us|µs|ms|s|m|h))+)|((((\d+,)+\d+|(\d+(\/|-)\d+)|\d+|\*) ?){5,7})/'),
            'timeout' => 'required|integer', //default 60
            'attempts' => 'required|integer', //default 1
            'retry_waits' => 'required|integer', //default 5000
            'name' => 'nullable|max:255',
            'site' => 'nullable|max:255',
            'email' => 'nullable|email|max:255',
            'log_type' => 'required|integer', //default 0
            'status' => 'required|integer', //default 0
            'enabled' => 'required|boolean', //default 0
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date'
        ]);

        if($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        $webCronTask->url = $request->input('url');
        $webCronTask->schedule = $request->input('schedule'); 
        $webCronTask->timeout = $request->input('timeout'); 
        $webCronTask->attempts = $request->input('attempts'); 
        $webCronTask->retry_waits = $request->input('retry_waits'); 
        $webCronTask->name = $request->input('name'); 
        $webCronTask->site = $request->input('site'); 
        $webCronTask->email = $request->input('email'); 
        $webCronTask->log_type = $request->input('log_type'); 
        $webCronTask->status = $request->input('status'); 
        $webCronTask->enabled = $request->input('enabled'); 
        $webCronTask->start_date = $request->input('start_date'); 
        $webCronTask->end_date = $request->input('end_date');
        $webCronTask->save();

        return response()->json($webCronTask, 200);
    }

    // Route::patch('/tasks/{id}', 'App\Http\Controllers\WebCronTaskController@partialUpdateTask');
    public function partialUpdateTask(Request $request, $id) {
        $webCronTask = WebCronTask::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'url' => 'sometimes|required|max:255',
            'schedule' =>array('sometimes','required','max:255','regex:/(@(annually|yearly|monthly|weekly|daily|hourly|reboot))|(@every (\d+(ns|us|µs|ms|s|m|h))+)|((((\d+,)+\d+|(\d+(\/|-)\d+)|\d+|\*) ?){5,7})/'),
            'timeout' => 'sometimes|required|integer', //default 60
            'attempts' => 'sometimes|required|integer', //default 1
            'retry_waits' => 'sometimes|required|integer', //default 5000
            'name' => 'sometimes|nullable|max:255',
            'site' => 'sometimes|nullable|max:255',
            'email' => 'sometimes|nullable|email|max:255',
            'log_type' => 'sometimes|required|integer', //default 0
            'status' => 'sometimes|required|integer', //default 0
            'enabled' => 'sometimes|required|boolean', //default 0
            'start_date' => 'sometimes|nullable|date',
            'end_date' => 'sometimes|nullable|date'
        ]);

        if($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        if($request->has('url')) {
            $webCronTask->url = $request->input('url');
        }
        
        if($request->has('schedule')) {
            $webCronTask->schedule = $request->input('schedule');
        }
        
        if($request->has('timeout')) {
            $webCronTask->timeout = $request->input('timeout');
        }
        
        if($request->has('attempts')) {
            $webCronTask->attempts = $request->input('attempts');
        }
        
        if($request->has('retry_waits')) {
            $webCronTask->retry_waits = $request->input('retry_waits');
        }
        
        if($request->has('name')) {
            $webCronTask->name = $request->input('name');
        }
        
        if($request->has('site')) {
            $webCronTask->site = $request->input('site');
        }
        
        if($request->has('email')) {
            $webCronTask->email = $request->input('email');
        }
        
        if($request->has('log_type')) {
            $webCronTask->log_type = $request->input('log_type');
        }
        
        if($request->has('status')) {
            $webCronTask->status = $request->input('status');
        }
        
        if($request->has('enabled')) {
            $webCronTask->enabled = $request->input('enabled');
        }
        
        if($request->has('start_date')) {
            $webCronTask->start_date = $request->input('start_date');
        }
        
        if($request->has('end_date')) {
            $webCronTask->end_date = $request->input('end_date');
        }

        $webCronTask->save();

        return response()->json($webCronTask, 200);

    }


}
