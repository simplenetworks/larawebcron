<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsWebCronTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('web_cron_tasks', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->string('site')->nullable();
            $table->string('email')->nullable();
            $table->smallInteger('log_type')->default(0);
            $table->smallInteger('status')->default(0);
            $table->boolean('enabled')->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();



            // $table->string('name')->after('id');
            // $table->string('site')->after('name');
            // $table->string('email');
            // $table->smallInteger('log_type')->after('email')->default(0);
            // $table->smallInteger('status')->default(0);
            // $table->boolean('enabled')->after('enabled')->default(0);
            // $table->date('start_date')->after('enabled');
            // $table->date('end_date')->after('start_date');

            //category
            // max_runs
            // next_task_id


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('web_cron_tasks', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('site');
            $table->dropColumn('email');
            $table->dropColumn('log_type');
            $table->dropColumn('status');
            $table->dropColumn('enabled');
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
        });
    }
}
