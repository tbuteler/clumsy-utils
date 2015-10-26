<?php
namespace Clumsy\Utils\Validators\PT;

use Illuminate\Support\Facades\DB;

class Postal
{
    public function validate($attribute, $value, $parameters)
    {
        if (!preg_match('/^[0-9]{4}\-[0-9]{3}$/', $value)) {
            return false;
        }

        if ((int)substr($value, 0, 4) < 1000) {
            return false;
        }

        if (!DB::table('utils_geo_pt_address_lookup')->where('code_prefix', substr($value, 0, 4))->first()) {
            return false;
        }

        return true;
    }
}
