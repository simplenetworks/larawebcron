<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\WebCronTask;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests\StoreWebCronTaskRequest;
use App\Http\Requests\UpdateWebCronTaskRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Models\WebCronResult;

const REGEX_CRON = "/(@(annually|yearly|monthly|weekly|daily|hourly|reboot))|(@every (\d+(ns|us|µs|ms|s|m|h))+)|(\*|(?:[0-9]|(?:[1-5][0-9]))(?:(?:\-[0-9]|\-(?:[1-5][0-9]))?|(?:\,(?:[0-9]|(?:[1-5][0-9])))*)) (\*|(?:[0-9]|1[0-9]|2[0-3])(?:(?:\-(?:[0-9]|1[0-9]|2[0-3]))?|(?:\,(?:[0-9]|1[0-9]|2[0-3]))*)) (\*|(?:[1-9]|(?:[12][0-9])|3[01])(?:(?:\-(?:[1-9]|(?:[12][0-9])|3[01]))?|(?:\,(?:[1-9]|(?:[12][0-9])|3[01]))*)) (\*|(?:[1-9]|1[012]|JAN|FEB|MAR|APR|MAY|JUN|JUL|AUG|SEP|OCT|NOV|DEC)(?:(?:\-(?:[1-9]|1[012]|JAN|FEB|MAR|APR|MAY|JUN|JUL|AUG|SEP|OCT|NOV|DEC))?|(?:\,(?:[1-9]|1[012]|JAN|FEB|MAR|APR|MAY|JUN|JUL|AUG|SEP|OCT|NOV|DEC))*)) (\*|(?:[0-6]|SUN|MON|TUE|WED|THU|FRI|SAT)(?:(?:\-(?:[0-6]|SUN|MON|TUE|WED|THU|FRI|SAT))?|(?:\,(?:[0-6]|SUN|MON|TUE|WED|THU|FRI|SAT))*))$/";
//const REGEX_EMAIL = "/^\S+@\S+\.\S+$/";
const REGEX_EMAIL = "/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/"; //accept email@localhost
// different regex validator email, ref. http://emailregex.com/
// const REGEX_EMAIL = "/(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])";

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
            'schedule' =>array('required','max:255',"regex:" .REGEX_CRON),
            'timeout' => 'required|integer', //default 60
            'attempts' => 'required|integer', //default 1
            'retry_waits' => 'required|integer', //default 5000
            'name' => 'nullable|max:255',
            'site' => 'nullable|max:255',
            'email' => array('nullable','max:255',"regex:" .REGEX_EMAIL),
            'log_type' => 'required|integer', //default 0
            'status' => 'required|integer', //default 1
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

        WebCronResult::where('web_cron_task_id',$id)->delete();
        $webCronTask = WebCronTask::findOrFail($id);
        $webCronTask->delete();

        return response()->json(null, 204);
    }

    // Route::put('/tasks/{id}', 'App\Http\Controllers\WebCronTaskController@updateTask');
    public function updateTask(Request $request, $id) {
        $webCronTask = WebCronTask::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'url' => 'required|max:255',
            'schedule' =>array('required','max:255',"regex:" .REGEX_CRON),
            'timeout' => 'required|integer', //default 60
            'attempts' => 'required|integer', //default 1
            'retry_waits' => 'required|integer', //default 5000
            'name' => 'nullable|max:255',
            'site' => 'nullable|max:255',
            //'email' => 'nullable|email|max:255',
            'email' => array('nullable','max:255',"regex:" .REGEX_EMAIL),
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
            'schedule' =>array('sometimes','required','max:255',"regex:" .REGEX_CRON),
            'timeout' => 'sometimes|required|integer', //default 60
            'attempts' => 'sometimes|required|integer', //default 1
            'retry_waits' => 'sometimes|required|integer', //default 5000
            'name' => 'sometimes|nullable|max:255',
            'site' => 'sometimes|nullable|max:255',
            'email' => array('sometimes','nullable','max:255',"regex:" .REGEX_EMAIL),
            'log_type' => 'sometimes|required|integer', //default 0
            'status' => 'sometimes|required|integer', //default 1
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

    // gui controllers

    public function index()
    {
        abort_if(Gate::denies('task_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        //$webcrontasks = WebCronTask::orderBy('id','desc')->sortable()->paginate(10);
        $webcrontasks = WebCronTask::sortable('id')->paginate(10);

        return view('webcrontasks.index', compact('webcrontasks'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function create()
    {
        abort_if(Gate::denies('task_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('webcrontasks.create');
    }

    public function store(StoreWebCronTaskRequest $request)
    {
        WebCronTask::create($request->validated());

        return redirect()->route('webcrontasks.index');
    }

    public function show(WebCronTask $webcrontask)
    {
        abort_if(Gate::denies('task_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('webcrontasks.show', compact('webcrontask'));
    }

    public function edit(WebCronTask $webcrontask)
    {
        abort_if(Gate::denies('task_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('webcrontasks.edit', compact('webcrontask'));
    }

    public function update(UpdateWebCronTaskRequest $request, WebCronTask $webcrontask)
    {
        $webcrontask->update($request->validated());

        return redirect()->route('webcrontasks.index');
    }

    public function destroy(WebCronTask $webcrontask)
    {
        abort_if(Gate::denies('task_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        WebCronResult::where('web_cron_task_id',$webcrontask->id)->delete();

        $webcrontask->delete();

        return redirect()->route('webcrontasks.index');
    }

    public function changeTaskEnabled(WebCronTask $webcrontask)
    {

        abort_if(Gate::denies('task_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $webcrontask->enabled = !$webcrontask->enabled;
        $webcrontask->save();

        return redirect()->route('webcrontasks.index');

    }

    public function duplicateTask(WebCronTask $webcrontask)
    {

        abort_if(Gate::denies('task_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $webCronTaskNew = new WebCronTask();
        $webCronTaskNew = $webcrontask->replicate();
        $webCronTaskNew->enabled = 0;
        $webCronTaskNew->status = 1;
        $webCronTaskNew->save();

        return redirect()->route('webcrontasks.edit',$webCronTaskNew->id);

    }

}
