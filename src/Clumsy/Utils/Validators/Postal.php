<?php
namespace Clumsy\Utils\Validators;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;

class Postal
{
    public function validate($attribute, $value, $parameters)
    {
        // If no country or method for obtaining country was defined, approve all values
        if (!sizeof($parameters)) {
            return true;
        }

        switch (head($parameters)) {
            case 'field':
                $country = Input::get($parameters[1]);

                break;

            case 'locale':
                $country = Config::get('app.locale');

                break;

            default:
                $country = head($parameters);
        }

        $object = 'Clumsy\Utils\Validators\\'.Str::upper($country).'\Postal';

        return with(new $object)->validate($attribute, $value, $parameters);
    }
}
