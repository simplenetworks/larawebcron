<?php

namespace App;

use App\Models\WebCronTask;
use App\Models\WebCronResult;

use App\Mail\ResultEmail;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Cron\CronExpression;

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
        $nextDate = new CronExpression($webCronTaskExpression);
        return $nextDate->getNextRunDate($date->toDateTimeString())->format('Y-m-d H:i:s');

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

    /**
     * Get the status of system
     *
     * @return integer
     *
     */
    public static function getSystemStatus(){

        $webCronResult = WebCronResult::orderBy('code', 'desc')->first();

        if ($webCronResult) {

            if ($webCronResult->code >= 300) {
                // bad status
                return 0;
            }else{
                // good status
                return 2;
            };

        }else{
            // No execution
            return 1;

        };

    }

    /**
     * Get the next task execution in the system
     *
     * @return string
     *
     */
    public static function getNextTaskExecution(){

        $current_day = Carbon::now();

        $tasks = WebCronTask::where('enabled', TRUE)
                            ->where('start_date', '<=', $current_day)
                            ->where('end_date', '>=', $current_day)
                            ->where(function($query) {
                                $query->whereRaw('max_runs > (SELECT count(id) FROM web_cron_results where web_cron_task_id= web_cron_tasks.id) ')
                                ->orWhere('max_runs', '=', 0);})
                            ->limit(5)
                            ->get();
                        $tasks = $tasks->sortBy('next_run_date');

        if ($tasks) {

            return $tasks;

        }else{

            // No tasks
            return null;

        };

    }

}
