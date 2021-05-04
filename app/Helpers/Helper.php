<?php

//namespace App\Helper;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\WebCronTask;
use App\Models\WebCronResult;
use Illuminate\Support\Facades\Http;
use Log, DB;


/**
 * Change the web_cron_tasks.status for $taskId
 * in setTaskStatus the task is already enabled
 * Values:
 *  0 with critical errors
 *  1 task enabled but newer executed or task disalbled with critical error
 *  2 task enabled and with no error
 *
 * @return void
 *
 * @param $taskId
 *
 */
function setTaskStatus($taskId){

    $webCronResults = WebCronResult::where('web_cron_task_id',$taskId)->orderBy('code', 'desc')->firstOrFail();

    if ($webCronResults->count() > 0) {

        $webCronTask = WebCronTask::findOrFail($taskId);

        if ($webCronResults->code>=300) {
            // bad status
            $webCronTask->status = 0 ;
        }else{
            // good status
            $webCronTask->status = 2 ;
        };

        $webCronTask->save();

    };

}

/**
 * Return the number of executions of task in $taskId
 *
 *
 * @return integer
 *
 * @param $taskId
 *
 */
function getNumberTaskExecutions($taskId){

    $webCronResults = WebCronResult::selectRaw('count(*) as executions')->where('web_cron_task_id',$taskId)->count('id')->firstOrFail();

    if ($webCronResults->count() > 0) {

        return $webCronResults->executions;

    }else{

        return 0;

    };

}
