<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WebCronTask;

class WebCronTasksTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        //WebCronTask::delete();

        WebCronTask::insert(array (
            0 =>
            array (
                'id' => 1,
                'url' => 'https://reqres.in/api/users/2',
                'schedule' => '* * * * *',
                'timeout' => 10,
                'attempts' => 1,
                'retry_waits' => 100,
                'created_at' => '2021-04-25 08:10:10',
                'updated_at' => '2021-04-25 08:10:10',
                'name' => 'reqres user 2',
                'site' => 'reqres.in',
                'email' => 'admin@admin.com',
                'log_type' => 2,
                'status' => 1,
                'enabled' => 0,
                'start_date' => '2021-04-25',
                'end_date' => '2021-06-25',
                'max_runs' => 0,
            ),
            1 =>
            array (
                'id' => 2,
                'url' => 'https://reqres.in/api/users/3',
                'schedule' => '* * * * *',
                'timeout' => 10,
                'attempts' => 1,
                'retry_waits' => 100,
                'created_at' => '2021-04-25 08:10:10',
                'updated_at' => '2021-04-25 08:10:10',
                'name' => 'reqres user 3',
                'site' => 'reqres.in',
                'email' => 'admin@admin.com',
                'log_type' => 2,
                'status' => 1,
                'enabled' => 1,
                'start_date' => '2021-04-25',
                'end_date' => '2021-06-25',
                'max_runs' => 10,
            ),
            2 =>
            array (
                'id' => 3,
                'url' => 'https://jsonplaceholder.typicode.com/photos/e/139',
                'schedule' => '1 0-5 * 1-5 *',
                'timeout' => 143,
                'attempts' => 3,
                'retry_waits' => 100,
                'created_at' => '2021-04-29 08:01:55',
                'updated_at' => '2021-05-21 13:39:39',
                'name' => 'Site reqres ERROR',
                'site' => 'reqres.inw TASK WITH ERROR',
                'email' => 'admin@admin.com',
                'log_type' => 1,
                'status' => 1,
                'enabled' => 1,
                'start_date' => '2021-04-25',
                'end_date' => '2021-06-25',
                'max_runs' => 80,
            ),
        ));


    }
}
