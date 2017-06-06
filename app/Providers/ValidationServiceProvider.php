<?php

namespace Korona\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class ValidationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('phonenumber', function ($attribute, $value, $parameters, $validator) {
            $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
            try {
                $numberProto = $phoneUtil->parse($value, $parameters[0]);
            } catch (\libphonenumber\NumberParseException $e) {
                return false;
            }
            return $phoneUtil->isValidNumber($numberProto);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
