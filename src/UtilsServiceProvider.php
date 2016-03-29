<?php

namespace Clumsy\Utils;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
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
        $this->mergeConfigFrom(__DIR__.'/config/field.php', 'clumsy.field');
        $this->mergeConfigFrom(__DIR__.'/config/assets.php', 'clumsy.assets.utils');
        $this->mergeConfigFrom(__DIR__.'/config/environment-locale.php', 'clumsy.environment-locale');

        $this->app->register('Collective\Html\HtmlServiceProvider');

        $this->app->bind('clumsy.http', function () {
            return new Library\HTTP;
        });

        $this->app->bind('clumsy.field', function () {
            return new Library\FieldFactory;
        });
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
            $locale = app()->getLocale();
            $fallbacks = $this->app['config']->get('clumsy.environment-locale.fallbacks');
            if (isset($fallbacks[$locale])) {
                $this->app['translator']->setFallback($fallbacks[$locale]);
            }
        }

        $this->loadViewsFrom(__DIR__.'/views', 'clumsy/utils');

        $this->registerPublishers();

        $this->registerValidators();

        $this->registerBladeDirectives();
    }

    protected function registerPublishers()
    {
        $this->publishes([
            __DIR__.'/config/config.php' => config_path('clumsy/utils.php'),
            __DIR__.'/config/field.php' => config_path('clumsy/field.php'),
            __DIR__.'/config/assets.php' => config_path('clumsy/assets/utils.php'),
            __DIR__.'/config/environment-locale.php' => config_path('clumsy/environment-locale.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/lang' => base_path('resources/lang/vendor/clumsy/utils'),
        ], 'translations');

        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/vendor/clumsy/utils'),
        ], 'views');

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/clumsy/utils'),
        ], 'public');
    }

    protected function registerValidators()
    {
        if (!$this->app['config']->get('clumsy.utils.enable-validators')) {
            return;
        }

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

    protected function registerBladeDirectives()
    {
        if (!$this->app['config']->get('clumsy.utils.enable-blade-directives')) {
            return;
        }

        Blade::directive('form', function ($expression) {

            if (!$expression) {
                $expression = '()';
            }

            return "<?php echo Collective\Html\FormFacade::open{$expression}; ?>";
        });

        Blade::directive('formModel', function ($expression) {

            return "<?php echo Collective\Html\FormFacade::model{$expression}; ?>";
        });

        Blade::directive('endform', function ($expression) {

            if (!$expression) {
                $expression = '()';
            }

            return "<?php echo Collective\Html\FormFacade::close{$expression}; ?>";
        });

        Blade::directive('field', function ($expression) {
            return "<?php echo app('clumsy.field')->make{$expression}; ?>";
        });

        $directives = [
            'checkbox',
            'dropdown',
            'password',
            'textarea',
            'richText',
            'datepicker',
            'datetimepicker',
            'timepicker',
            'colorpicker',
            'embedVideo',
            'hidden',
        ];

        foreach ($directives as $directive) {

            Blade::directive($directive, function ($expression) use ($directive) {
                return "<?php echo app('clumsy.field')->{$directive}{$expression}; ?>";
            });
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'clumsy.http',
            'clumsy.field',
        ];
    }
}
