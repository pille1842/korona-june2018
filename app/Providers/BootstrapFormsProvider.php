<?php

namespace Korona\Providers;

use Illuminate\Support\ServiceProvider;
use Form;

class BootstrapFormsProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Form::component('bsCheckbox', 'components.form.checkbox', ['name', 'value' => null, 'checked' => false]);
        Form::component('bsEmail', 'components.form.email', ['name', 'value' => null, 'attributes' => []]);
        Form::component('bsText', 'components.form.text', ['name', 'value' => null, 'attributes' => []]);
        Form::component('bsPassword', 'components.form.password', ['name', 'attributes' => []]);
        Form::component('bsSlug', 'components.form.slug', ['name', 'value' => null, 'source', 'attributes' => []]);
        Form::component('bsSelect', 'components.form.select', ['name', 'options', 'value' => null, 'attributes' => []]);
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
