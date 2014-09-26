<?php namespace Clumsy\Utils\Facades;

class EnvironmentLocale extends \Illuminate\Support\Facades\Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return '\Clumsy\Utils\Library\EnvironmentLocale'; }

}