<?php

namespace Korona\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Response::macro('attachment', function ($content, $type, $filename) {

            $headers = [
                'Content-type'        => $type,
                'Content-Disposition' => 'attachment;filename="'.$filename.'"',
            ];

            return \Response::make($content, 200, $headers);

        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Carbon::setLocale(config('app.locale'));
        setlocale(LC_TIME, config('app.strftime_locale'));
    }
}
