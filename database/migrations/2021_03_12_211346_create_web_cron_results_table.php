<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebCronResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_cron_results', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('code'); //Http status code
            $table->integer('duration'); //Duration in seconds
            $table->longText('body'); //Response body
            $table->foreignId('web_cron_task_id')->constrained('web_cron_tasks');
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
        Schema::dropIfExists('web_cron_results');
    }
}
