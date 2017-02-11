<?php

namespace Clumsy\Utils\Validation;

class CurrentPassword
{
    public function validate($attribute, $value, $parameters)
    {
        $guard = count($parameters) ? head($parameters) : null;
        if (!auth($guard)->check()) {
            return false;
        }

        return auth($guard)->getProvider()->validateCredentials(auth($guard)->user(), ['password' => $value]);
    }
}
