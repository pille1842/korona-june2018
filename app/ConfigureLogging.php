<?php

namespace Korona;

use Illuminate\Log\Writer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Bootstrap\ConfigureLogging as BaseLoggingBootstrapper;

class ConfigureLogging extends BaseLoggingBootstrapper
{
    /**
     * Configure the Monolog handlers for the application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @param  \Illuminate\Log\Writer  $log
     * @return void
     */
    protected function configureSingleHandler(Application $app, Writer $log)
    {
        $log->useFiles(
            $app->storagePath().'/logs/korona.log',
            $app->make('config')->get('app.log_level', 'debug')
        );
    }

    /**
     * Configure the Monolog handlers for the application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @param  \Illuminate\Log\Writer  $log
     * @return void
     */
    protected function configureDailyHandler(Application $app, Writer $log)
    {
        $config = $app->make('config');

        $maxFiles = $config->get('app.log_max_files');

        $log->useDailyFiles(
            $app->storagePath().'/logs/korona.log', is_null($maxFiles) ? 5 : $maxFiles,
            $config->get('app.log_level', 'debug')
        );
    }

    /**
     * Configure the Monolog handlers for the application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @param  \Illuminate\Log\Writer  $log
     * @return void
     */
    protected function configureSyslogHandler(Application $app, Writer $log)
    {
        $log->useSyslog(
            'korona',
            $app->make('config')->get('app.log_level', 'debug')
        );
    }
}
