<?php

namespace Clumsy\Utils\Validators\PT;

class Identities
{
    public function nif($attribute, $value, $parameters)
    {
        if (!is_numeric($value) || strlen($value) !== 9) {
            return false;
        }

        $array = str_split($value);

        if (!in_array($array[0], [1, 2, 5, 6, 8, 9])) {
            return false;
        }

        $control = 0;
        for ($i = 1; $i <= 8; $i++) {
            $control += $array[$i - 1] * (10 - $i);
        }
        $control = 11 - ($control % 11);
        if ($control >= 10) {
            $control = 0;
        }
        if (((int)$array[8]) !== $control) {
            return false;
        }

        return true;
    }
}
