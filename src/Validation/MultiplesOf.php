<?php

namespace Clumsy\Utils\Validation;

class MultiplesOf
{
    public function validate($attribute, $value, $parameters)
    {
        if ($value % head($parameters) != 0) {
            return false;
        }

        return true;
    }
}
