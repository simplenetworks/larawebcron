<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\WebCronResult;
use Illuminate\Support\Facades\Validator;

class WebCronResultController extends Controller
{
    // Route::get('/results', 'App\Http\Controllers\WebCronResultController@getResults');
    public function getResults() {
        //Leggere tutti i record della tabella web_cron_results
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

        //Emettere una risposta
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


}
