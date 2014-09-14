<?php namespace Clumsy\Utils\Library;

use Illuminate\Support\Facades\Lang;
use Carbon\Carbon;

class Date {

	public function __construct()
	{
		$locale = class_exists('Clumsy\Locale\Facade') ? \Clumsy\Locale\Facade::codes() : app('config')->get('app.locale');
	
		setlocale(LC_TIME, $locale);
	}
    
    public function format($date, $format)
    {
        if (Lang::has("clumsy/utils::dates.$format"))
        {
            $format = Lang::get("clumsy/utils::dates.$format");
        }

        $date = new Carbon($date);

        return $date->formatLocalized($format);
    }
}
