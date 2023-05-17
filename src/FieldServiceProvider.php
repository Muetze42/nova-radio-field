<?php

namespace NormanHuth\NovaRadioField;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;
use NormanHuth\NovaBasePackage\ServiceProviderTrait;

class FieldServiceProvider extends ServiceProvider
{
    use ServiceProviderTrait;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Nova::serving(function (ServingNova $event) {
            Nova::script('nova-radio-field', __DIR__.'/../dist/js/field.js');
        });

        $this->addAbout();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }
}
