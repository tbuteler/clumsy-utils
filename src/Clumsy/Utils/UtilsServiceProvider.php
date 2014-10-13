<?php namespace Clumsy\Utils;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
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

		require $this->guessPackagePath().'/macros/form.php';
		require $this->guessPackagePath().'/macros/string.php';

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
        Validator::extend('email_advanced', 'Clumsy\Utils\Validators\EmailAdvanced@validate');
		Validator::extend('postal', 'Clumsy\Utils\Validators\Postal@validate');
		Validator::extend('id', 'Clumsy\Utils\Validators\Identities@validate');
		Validator::replacer('id', function($message, $attribute, $rule, $parameters)
		{
			$id = head($parameters);
    		
    		return str_replace(':id', Lang::get("clumsy/utils::validation.identities.$id"), $message);
		});

		Validator::resolver(function($translator, $data, $rules, $messages)
		{
			// Append custom messages
			$messages = Lang::get('clumsy/utils::validation');

		    return new \Illuminate\Validation\Validator($translator, $data, $rules, $messages);
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
