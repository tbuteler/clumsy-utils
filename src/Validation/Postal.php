<?php

namespace Clumsy\Utils\Validation;

use Illuminate\Support\Str;

class Postal
{
    public function validate($attribute, $value, $parameters)
    {
        // If no country or method for obtaining country was defined, approve all values
        if (!count($parameters)) {
            return true;
        }

        switch (head($parameters)) {
            case 'field':
                $country = request($parameters[1]);

                break;

            case 'locale':
                $country = config('app.locale');

                break;

            default:
                $country = head($parameters);
        }

        $object = 'Clumsy\Utils\Validation\\'.Str::upper($country).'\Postal';

        return with(new $object)->validate($attribute, $value, $parameters);
    }
}
