<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebCronResult extends Model
{
    use HasFactory;

    public function webCronTask() {
        return $this->belongsTo('App\Models\WebCronTask');
    }
}
