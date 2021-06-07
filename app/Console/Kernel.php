<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\WebCronTask;
use App\Models\WebCronResult;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $current_day = Date('Y-m-d');

        $tasks = WebCronTask::where('enabled', TRUE)
                            ->where('start_date', '<=', $current_day)
                            ->where('end_date', '>=', $current_day)
                            ->where(function($query) {
                                $query->whereRaw('max_runs > (SELECT count(id) FROM web_cron_results where web_cron_task_id= web_cron_tasks.id) ')
                                ->orWhere('max_runs', '=', 0); //unlimited runs
                            })
                            ->get();

        foreach($tasks as $task) {

            $schedule->call(function() use ($task) {
                $logMessage = "Executed task name: '" .$task->name ."' (ID: " .$task->id .")";
                echo $logMessage.PHP_EOL;

                $start = time();
                $result = new WebCronResult();

                try {

                    $response = Http::timeout($task->timeout)->retry($task->attempts, $task->retry_waits)->get($task->url);

                    $result->body = utf8_encode($response->body());
                    $result->code = $response->status();

                } catch (\Exception $e)
                {

                    $result->body = utf8_encode('Caught exception: ' .$e->getMessage());
                    $result->code = 500;

                    Log::alert($logMessage);
                    Log::alert($e->getMessage());

                }

                $result->web_cron_task_id = $task->id;
                $result->duration = time() - $start;
                $result->save();

                // set status for current task
                $task->refreshTaskStatus();

                // send email with current task result
                $result->emailTaskResults($task->log_type);

           })->cron($task->schedule);

        }

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

