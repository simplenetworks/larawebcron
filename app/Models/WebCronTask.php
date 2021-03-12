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
}
