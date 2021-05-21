<?php

namespace App;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\WebCronTask;
use App\Models\WebCronResult;

use App\Mail\ResultEmail;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Http;
use DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Cron\CronExpression;
// use Illuminate\Console\Command;
// use Illuminate\Support\Str;

//use Lorisleiva\CronTranslator\CronTranslator;
use Panlatent\CronExpressionDescriptor\ExpressionDescriptor;

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

        //echo "Send mail for result Id: $resultId" .PHP_EOL;

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

    /**
     * Get datetime of next execution of scheduled task, based by cron expression.
     *
     * @return date
     */
    public static function getNextTaskRunDate($webCronTaskExpression)
    {
        $date = Carbon::now();

        if (config('app.timezone')) {
            $date->setTimezone(config('app.timezone'));
        }

        return (CronExpression::factory($webCronTaskExpression)->getNextRunDate($date->toDateTimeString()))->format('Y-m-d H:i:s');
    }

    /**
     * Get traslation of cron expression.
     *
     * @return string
     */
    public static function getTraslationOfCronExpression($webCronTaskExpression)
    {

        try {
            // $translate = CronTranslator::translate($webCronTaskExpression);
            $translate = (new ExpressionDescriptor($webCronTaskExpression))->getDescription();
            return $translate;

        } catch (\Exception $e)
        {
            Log::alert($e->getMessage());
            return "";
        }
    }

}
