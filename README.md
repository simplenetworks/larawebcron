# LaraWebCron
![Made with Laravel !](https://img.shields.io/badge/Made%20with-Laravel-orange)

LaraWebCron provides a gui for schedule, with CRON schedule schema, your HTTP request. 
Store and share the request response. You can define multiple parameters for execution of tasks, e.g.: date of start and end of execution, the number of executions, the type of log via e-mail. Export tasks or results in JSON format.

## Installation

1) In your Projects or www directory, wherever you host your apps:
```bash
git clone https://github.com/simplenetworks/larawebcron.git larawebcron
```
2) Install all the requirements:
```bash
cd laravebcron
composer install
```
3) Set your database information in your .env file (use .env.example as an example); Set your email smtp information too, for receive results email.

4) Populate the database (import user admin too) and stuff:
```bash
php artisan key:generate
php artisan migrate
php artisan db:seed
```
## Start server

```bash
php artisan serve
```

## Login or register
Login as admin (if the db is seeded)
user: admin@admin.com
password: password
[http://localhost:8000/login](http://localhost:8000/login)

(or as user, not admin user: user@user.com , password: password)

or register a new user ( NOT ADMIN)

[http://localhost:8000/register](http://localhost:8000/register)

only admin can set privileges for users.

## Task commands

Show the list of enabled and runnable tasks (the execution of task depends on cron schedule settings)
```bash
php artisan schedule:list
```

Execute the tasks:
```bash
php artisan schedule:run
```
## Cron Expression
A CRON expression is a string representing the schedule for a particular command to execute. For more [example](https://crontab.guru/#*_*_*_*).
The parts of a CRON schedule are as follows:
```

   *    *    *    *    *
   -    -    -    -    -
   |    |    |    |    |
   |    |    |    |    |
   |    |    |    |    +----- day of week (0 - 7) (Sunday=0 or 7)
   |    |    |    +---------- month (1 - 12)
   |    |    +--------------- day of month (1 - 31)
   |    +-------------------- hour (0 - 23)
   +------------------------- min (0 - 59)
                                   
This system also supports a few macros:

@yearly, @annually - Run once a year, midnight, Jan. 1 - 0 0 1 1 *
@monthly - Run once a month, midnight, first of month - 0 0 1 * *
@weekly - Run once a week, midnight on Sun - 0 0 * * 0
@daily - Run once a day, midnight - 0 0 * * *
@hourly - Run once an hour, first minute - 0 * * * *
```
## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.
