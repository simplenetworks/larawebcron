<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\WebCronTask;
use App\Models\WebCronResult;
use Illuminate\Support\Facades\Http;
use Log;

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
        $tasks = WebCronTask::get();
        foreach($tasks as $task) {
            $schedule->call(function() use ($task) {
                $start = time();
                $response = Http::get($task->url);
                $result = new WebCronResult();
                $result->code = $response->status();
                $result->body = $response->body();
                $result->web_cron_task_id = $task->id;
                $result->duration = time() - $start;
                $result->save();       
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
