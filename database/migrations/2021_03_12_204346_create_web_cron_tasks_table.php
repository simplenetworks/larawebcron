<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebCronTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_cron_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->string('schedule');
            $table->smallInteger('timeout')->default(60);
            $table->smallInteger('attempts')->default(1);
            $table->integer('retry_waits')->default(5000);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('web_cron_tasks');
    }
}
