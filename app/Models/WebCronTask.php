<?php

namespace App\Models;
use App\LaraWebCronFunctions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class WebCronTask extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'url',
        'schedule',
        'timeout',
        'attempts',
        'retry_waits',
        'name',
        'site',
        'email',
        'log_type',
        'enabled',
        'start_date',
        'end_date',
        'max_runs'
    ];


    public $sortable = [
        'id',
        'status',
        'schedule',
        'name',
        'enabled',
        'next_run_date'
    ];

/**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'next_run_date',
    ];

    public function webCronResults() {
        return $this->hasMany('App\Models\WebCronResult');
    }

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
    public function refreshTaskStatus(){

        $webCronResult = $this->webCronResults()->orderBy('code', 'desc')->first();

        if ($webCronResult) {

            if ($webCronResult->code >= 300) {
                // bad status
                $this->status = 0 ;
            }else{
                // good status
                $this->status = 2 ;
            };

            $this->save();

        };

    }

    /**
     * Get next run date of the task
     *
     * @return date
     *
     */
    public function getNextRunDateAttribute(){

        return LaraWebCronFunctions::getNextTaskRunDate($this->schedule);

    }

    // public function checkTasksStatus(){

    //     $current_day = Carbon::now();

    //     if ($current_day> $this->end_date){
    //         $this->enabled = 0;
    //         $this->save();
    //     }

    // }

}
