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
        Form::component('bsCheckbox', 'components.form.checkbox', ['name', 'value' => null, 'checked' => false, 'label' => null]);
        Form::component('bsEmail', 'components.form.email', ['name', 'value' => null, 'attributes' => [], 'label' => null]);
        Form::component('bsText', 'components.form.text', ['name', 'value' => null, 'attributes' => [], 'label' => null]);
        Form::component('bsTextarea', 'components.form.textarea', ['name', 'value' => null, 'attributes' => [], 'label' => null]);
        Form::component('bsPassword', 'components.form.password', ['name', 'attributes' => [], 'label' => null]);
        Form::component('bsSlug', 'components.form.slug', ['name', 'value' => null, 'source', 'attributes' => [], 'label' => null]);
        Form::component('bsSelect', 'components.form.select', ['name', 'options', 'value' => null, 'attributes' => [], 'label' => null]);
        Form::component('bsDate', 'components.form.date', ['name', 'value' => null, 'attributes' => [], 'label' => null]);
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
