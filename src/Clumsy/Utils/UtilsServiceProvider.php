<?php namespace Clumsy\Utils;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Clumsy\Assets\Facade as Asset;

class UtilsServiceProvider extends ServiceProvider {

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
	public function register() {}

	/**
	 * Boot the service provider.
	 *
	 * @return void
	 */
	public function boot()
	{
        $path = __DIR__.'/../..';

        $this->package('clumsy/utils', 'clumsy/utils', $path);

        $assets = Config::get('clumsy/utils::assets');
		Asset::batchRegister($assets);

        require $this->guessPackagePath().'/macros/string.php';
		require $this->guessPackagePath().'/macros/form.php';
        require $this->guessPackagePath().'/macros/html.php';

		// Locale fallbacks
		if (!Config::get('clumsy/utils::locales.passive'))
		{
			$locale = App::getLocale();
			$fallbacks = Config::get('clumsy/utils::locales.fallbacks');
			if (isset($fallbacks[$locale]))
			{
				Lang::setFallback($fallbacks[$locale]);
			}
		}

		// Extended validation

        $this->app['validator']->extend(
        	'multiples_of',
        	'Clumsy\Utils\Validators\MultiplesOf@validate',
        	Lang::get('clumsy/utils::validation.multiples_of')
        );
		$this->app['validator']->replacer('multiples_of', function($message, $attribute, $rule, $parameters)
		{
    		return str_replace(':multiple', head($parameters), $message);
		});

        $this->app['validator']->extend(
        	'email_advanced',
        	'Clumsy\Utils\Validators\EmailAdvanced@validate',
        	Lang::get('clumsy/utils::validation.email_advanced')
        );

		$this->app['validator']->extend(
			'postal',
			'Clumsy\Utils\Validators\Postal@validate',
			Lang::get('clumsy/utils::validation.postal')
		);

		$this->app['validator']->extend(
			'id',
			'Clumsy\Utils\Validators\Identities@validate',
			Lang::get('clumsy/utils::validation.id')
		);
		$this->app['validator']->replacer('id', function($message, $attribute, $rule, $parameters)
		{
			$id = head($parameters);

    		return str_replace(':id', Lang::get("clumsy/utils::validation.identities.$id"), $message);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
