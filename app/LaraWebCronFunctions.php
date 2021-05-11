<?php

namespace App;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\WebCronTask;
use App\Models\WebCronResult;

use App\Mail\ResultEmail;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Http;
use Log, DB;

class LaraWebCronFunctions
{
    /**
     * Send email with details of execution of task in $resultId
     *
     *
     * @param $resultId
     *
     */
    public static function sendResultEmailById($resultId){

        echo "Send mail for result Id: $resultId" .PHP_EOL;

        //$webCronResults = WebCronResult::selectRaw('count(*) as executions')->where('id',$resultId)->count('id')->firstOrFail();
        $webCronResult = WebCronResult::join('web_cron_tasks', 'web_cron_results.web_cron_task_id', '=', 'web_cron_tasks.id')
                                        ->select('web_cron_results.id','name','url', 'code','duration', 'body','web_cron_results.updated_at','log_type', 'email')
                                        ->findOrFail($resultId);

        if ($webCronResult->count() > 0) {

            Mail::to($webCronResult->email)->send(new ResultEmail($webCronResult));

        }else{

            //

        };

    }

}
