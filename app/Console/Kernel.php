<?php

namespace Korona\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Contracts\Foundation\Application;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }

    public function __construct(Application $app, Dispatcher $events)
    {
        parent::__construct($app, $events);

        $loggingKey = array_search('Illuminate\Foundation\Bootstrap\ConfigureLogging', $this->bootstrappers);
        $this->bootstrappers[$loggingKey] = 'Korona\ConfigureLogging';
    }
}
