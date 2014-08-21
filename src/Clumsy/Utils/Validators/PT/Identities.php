<?php namespace Clumsy\Utils\Validators\PT;

class Identities {

    public function nif($attribute, $value, $parameters)
    {
        if (!is_numeric($value) || strlen($value) !== 9)
        {
            return false;
        }

        $starts = array(1, 2, 5, 6, 8, 9);
        foreach ($starts as $start)
        {
            if (!starts_with($value, $start))
            {
                return false;
            }
        }

        $control = 0;
        $array = str_split($value);

        for ($i = 1; $i <= 8; $i++)
        {
            $control += $array[$i - 1] * (10 - $i);
        }

        $control = 11 - ($control % 11);

        if ($control >= 10)
        {
            $control = 0;
        }

        if (((int)$array[8]) !== $control)
        {
            return false;
        }

        return true;
    }
}