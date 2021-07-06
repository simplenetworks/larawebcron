<?php

namespace App\Http\Controllers;

use App\LaraWebCronFunctions;

class ResultMailController extends Controller
{
    public function sendResult($id)
    {

        LaraWebCronFunctions::sendResultEmailById($id);

    }

}
