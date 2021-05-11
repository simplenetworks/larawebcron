<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebCronTask extends Model
{
    use HasFactory;

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

}

