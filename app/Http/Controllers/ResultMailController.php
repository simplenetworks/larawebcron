<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\WebCronResult;
// serve??
use App\Models\WebCronTask;

use App\LaraWebCronFunctions;

//use Illuminate\Support\Facades\Validator;

use App\Mail\ResultEmail;

use Illuminate\Support\Facades\Mail;

class ResultMailController extends Controller
{
    public function sendResult($id)
    {

        LaraWebCronFunctions::sendResultEmailById($id);

    }

}
