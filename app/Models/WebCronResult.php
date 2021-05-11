<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\LaraWebCronFunctions;

class WebCronResult extends Model
{
    use HasFactory;

    public function webCronTask() {
        return $this->belongsTo('App\Models\WebCronTask');
    }

    /**
     * send email with details of current task result
     * with tasks.log_type logic:
     * Values log_type:
     *  0 never
     *  1 with critical error
     *  2 always
     *
     * @return void
     *
     * @param $taskLogType
     *
     */
    public function emailTaskResults($taskLogType = 1){

        switch ($taskLogType) {
            case 0: //never
                break;

            case 1: // with error
                if ($this->code < 300) break;

            default: // always (log_type 2)
                LaraWebCronFunctions::sendResultEmailById($this->id);
                break;
            }
    }

}
