<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\WebCronResult;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

use App\LaraWebCronFunctions;
use \Illuminate\Support\Str;

class WebCronResultController extends Controller
{
    // Route::get('/results', 'App\Http\Controllers\WebCronResultController@getResults');
    public function getResults() {

        $webCronResults = WebCronResult::orderBy('updated_at','desc')->get();
        return response()->json($webCronResults, 200);
    }

    // Route::get('/results/{id}', 'App\Http\Controllers\WebCronResultController@getSingleResult');
    public function getSingleResult($id) {
        //$webCronResult = WebCronResult::with('webCronTask')->findOrFail($id);
        $webCronResult = WebCronResult::findOrFail($id);
        return response()->json($webCronResult, 200);
    }

    // Route::post('/results', 'App\Http\Controllers\WebCronResultController@createResult');
    public function createResult(Request $request) {

        $validator = Validator::make($request->all(),[
            'code' => 'required|integer',
            'duration' => 'required|integer',
            'body' => 'required|string',
            'web_cron_task_id' => 'required|exists:web_cron_tasks,id'
        ]);

        if($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        $webCronResult = new WebCronResult();
        $webCronResult->code = $request->input('code');
        $webCronResult->duration = $request->input('duration');
        $webCronResult->body = $request->input('body');
        $webCronResult->web_cron_task_id = $request->input('web_cron_task_id');
        $webCronResult->save();

        return response()->json($webCronResult, 201);
    }

    // Route::delete('/results/{id}', 'App\Http\Controllers\WebCronResultController@deleteResult');
    public function deleteResult($id) {
        $webCronResult = WebCronResult::findOrFail($id);
        $webCronResult->delete();

        return response()->json(null, 204);
    }

    // Route::put('/results/{id}', 'App\Http\Controllers\WebCronResultController@updateResult');
    public function updateResult(Request $request, $id) {
        $webCronResult = WebCronResult::findOrFail($id);

        $validator = Validator::make($request->all(),[
            'code' => 'required|integer',
            'duration' => 'required|integer',
            'body' => 'required|string',
            'web_cron_task_id' => 'required|exists:web_cron_tasks,id'
        ]);

        if($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        $webCronResult->code = $request->input('code');
        $webCronResult->duration = $request->input('duration');
        $webCronResult->body = $request->input('body');
        $webCronResult->web_cron_task_id = $request->input('web_cron_task_id');
        $webCronResult->save();

        return response()->json($webCronResult, 200);

    }

    // Route::patch('/results/{id}', 'App\Http\Controllers\WebCronResultController@partialUpdateResult');
    public function partialUpdateResult(Request $request, $id) {
        $webCronResult = WebCronResult::findOrFail($id);

        $validator = Validator::make($request->all(),[
            'code' => 'sometimes|required|integer',
            'duration' => 'sometimes|required|integer',
            'body' => 'sometimes|required|string',
            'web_cron_task_id' => 'sometimes|required|exists:web_cron_tasks,id'
        ]);

        if($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        if($request->has('code')) {
            $webCronResult->code = $request->input('code');
        }

        if($request->has('duration')) {
            $webCronResult->duration = $request->input('duration');
        }

        if($request->has('body')) {
            $webCronResult->body = $request->input('body');
        }

        if($request->has('web_cron_task_id')) {
            $webCronResult->web_cron_task_id = $request->input('web_cron_task_id');
        }

        $webCronResult->save();

        return response()->json($webCronResult,200);

    }

 // gui controllers

 public function index()
 {
    abort_if(Gate::denies('task_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    $webcronresults = WebCronResult::sortable('id')->paginate(10);

    return view('webcronresults.index', compact('webcronresults'))
        ->with('i', (request()->input('page', 1) - 1) * 10);
 }

public function search(Request $request)
{
    abort_if(Gate::denies('task_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    $string = Str::of($request->input('query'))->trim();

    $stringLen = Str::of($string)->length();

    if ($stringLen>0){

        $webcronresults = WebCronResult::where('code', 'like', '%' .$string .'%')
                                        ->orWhere('body',  'like', '%' .$string .'%')
                                        ->orWhere('id',  'like', '%' .$string .'%')
                                        ->orWhere('created_at',  'like', '%' .$string .'%')
                                        ->orWhere('updated_at',  'like', '%' .$string .'%')
                                        ->sortable('id')
                                        ->paginate(10);

    } else {

        $webcronresults = WebCronResult::sortable('id')->paginate(10);

    };

    return view('webcronresults.index', compact('webcronresults'))
        ->with('i', (request()->input('page', 1) - 1) * 10);
}

 public function show(WebCronResult $webcronresult)
 {
    abort_if(Gate::denies('task_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    return view('webcronresults.show', compact('webcronresult'));
 }

 public function showBodyResult(WebCronResult $webcronresult)
 {
    abort_if(Gate::denies('task_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    return view('webcronresults.showbody', compact('webcronresult'));
 }

 public function destroy(WebCronResult $webcronresult)
 {
    abort_if(Gate::denies('task_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    $webcronresult->delete();

    return redirect()->route('webcrontasks.show',$webcronresult->web_cron_task_id);

 }

 public function sendResultEmailById(WebCronResult $webcronresult)
 {
    abort_if(Gate::denies('task_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    LaraWebCronFunctions::sendResultEmailById($webcronresult->id);

    return redirect()->route('webcrontasks.show',$webcronresult->web_cron_task_id);
 }

 public function jsonResultsDownload()
 {

     $jsongFile = time() .'_larawebcron_results.json';

     return response()->streamDownload(function () {

         $data = WebCronResult::get();
         echo $data;

     }, $jsongFile);

 }


 public function jsonResultDownload(WebCronResult $webcronresult)
 {

     $jsongFile = time() .'_larawebcron_result_' .$webcronresult->id .'.json';

     return response()->streamDownload(function () use($webcronresult) {

         $data = WebCronResult::find($webcronresult->id);
         echo $data;

     }, $jsongFile);

 }

}
