<?php

namespace Clumsy\Utils;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Clumsy\Assets\Facade as Asset;

class UtilsServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/config.php', 'clumsy.utils');
        $this->mergeConfigFrom(__DIR__.'/config/assets.php', 'clumsy.assets.utils');
        $this->mergeConfigFrom(__DIR__.'/config/environment-locale.php', 'clumsy.environment-locale');

        $this->app->register('Collective\Html\HtmlServiceProvider');
    }

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/lang', 'clumsy/utils');

        $assets = $this->app['config']->get('clumsy.assets.utils');
        Asset::batchRegister($assets);

        // Locale fallbacks
        if (!$this->app['config']->get('clumsy.environment-locale.passive')) {
            $locale = App::getLocale();
            $fallbacks = $this->app['config']->get('clumsy.environment-locale.fallbacks');
            if (isset($fallbacks[$locale])) {
                Lang::setFallback($fallbacks[$locale]);
            }
        }

        $this->publishes([
            __DIR__.'/config/config.php' => config_path('clumsy/utils.php'),
            __DIR__.'/config/assets.php' => config_path('clumsy/assets/utils.php'),
            __DIR__.'/config/environment-locale.php' => config_path('clumsy/environment-locale.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/clumsy/utils'),
        ], 'public');

        $this->registerValidators();
    }

    protected function registerValidators()
    {
        $this->app['validator']->extend(
            'multiples_of',
            'Clumsy\Utils\Validators\MultiplesOf@validate',
            trans('clumsy/utils::validation.multiples_of')
        );
        $this->app['validator']->replacer('multiples_of', function ($message, $attribute, $rule, $parameters) {

            return str_replace(':multiple', head($parameters), $message);
        });

        $this->app['validator']->extend(
            'email_advanced',
            'Clumsy\Utils\Validators\EmailAdvanced@validate',
            trans('clumsy/utils::validation.email_advanced')
        );

        $this->app['validator']->extend(
            'postal',
            'Clumsy\Utils\Validators\Postal@validate',
            trans('clumsy/utils::validation.postal')
        );

        $this->app['validator']->extend(
            'id',
            'Clumsy\Utils\Validators\Identities@validate',
            trans('clumsy/utils::validation.id')
        );
        $this->app['validator']->replacer('id', function ($message, $attribute, $rule, $parameters) {

            $id = head($parameters);

            return str_replace(':id', trans("clumsy/utils::validation.identities.$id"), $message);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
