<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreWebCronTaskRequest extends FormRequest
{
    public function rules()
    {
        return [
            'url' => 'required|max:255',
            'schedule' =>array('required','max:255',"regex:" .config('larawebcron.regex_cron_expression')),
            'timeout' => 'required|integer', //default 60
            'attempts' => 'required|integer', //default 1
            'retry_waits' => 'required|integer', //default 5000
            'max_runs' => 'required|integer', //default 0
            'name' => 'nullable|max:255',
            'site' => 'nullable|max:255',
            'email' => array('nullable','max:255',"regex:" .config('larawebcron.regex_email')),
            'log_type' => 'required|integer', //default 0
            'enabled' => 'required|boolean', //default 0
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date'
        ];
    }

    public function authorize()
    {
        return Gate::allows('task_access');
    }

}
