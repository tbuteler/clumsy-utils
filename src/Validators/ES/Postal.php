<?php

namespace Clumsy\Utils\Validators\ES;

use Illuminate\Support\Facades\DB;

class Postal
{
    public function validate($attribute, $value, $parameters)
    {
        if (strlen((string)$value) !== 5) {
            return false;
        }

        if ((int)$value > 52999 || (int)$value < 1000) {
            return false;
        }

        $postals = DB::table('utils_geo_es_cities')
                     ->select(DB::raw('substr(postal,1,3) as prefix'))
                     ->distinct()
                     ->lists('prefix');

        if (!in_array(substr((string)$value, 0, 3), $postals)) {
            return false;
        }

        return true;
    }
}
