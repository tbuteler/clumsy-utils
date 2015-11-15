<?php
namespace Clumsy\Utils\Library;

use Illuminate\Support\Facades\Lang;
use Carbon\Carbon;

class Date
{
    public function __construct()
    {
        set_locale(LC_TIME);
    }

    public function format($date, $format)
    {
        if (Lang::has("clumsy/utils::dates.$format")) {
            $format = Lang::get("clumsy/utils::dates.$format");
        }

        if (!($date instanceof Carbon)) {
            $date = new Carbon($date);
        }

        return $date->formatLocalized($format);
    }
}
