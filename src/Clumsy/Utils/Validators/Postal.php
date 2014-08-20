<?php namespace Clumsy\Utils\Validators;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class Postal {

    public function validate($attribute, $value, $parameters)
    {
        // If no country or method for obtaining country was defined, approve all values
        if (!sizeof($parameters))
        {
            return true;
        }

        switch (head($parameters))
        {
            case 'field' :

                $country = Input::get($parameters[1]);

                break;

            case 'locale' :

                $country = Config::get('app.locale');

                break;

            default :

                $country = head($parameters);
        }

        switch ($country)
        {
            case 'es' :

                if (strlen((string)$value) !== 5)
                {
                    return false;
                }

                if ((int)$value > 52999 || (int)$value < 1000)
                {
                    return false;
                }

                $postals = DB::table('utils_geo_es_cities')
                             ->select(DB::raw('substr(postal,1,3) as prefix'))
                             ->distinct()
                             ->lists('prefix');

                if (!in_array(substr((string)$value, 0, 3), $postals))
                {
                    return false;
                }

                break;

            case 'pt' :

                if (!preg_match('/[0-9]{4}\-[0-9]{3}/', $value))
                {
                    return false;
                }
                
                if ((int)substr($value, 0, 4) < 1000)
                {
                    return false;
                }
                
                if (!DB::table('utils_geo_pt_address_lookup')->where('code_prefix', substr($value, 0, 4))->first())
                {
                    return false;
                }

                break;
        }
 
        return true;        
    }
}