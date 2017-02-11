<?php

namespace Clumsy\Utils\Validation;

class EmailAdvanced
{
    public function validate($attribute, $value, $parameters)
    {
        // First we validate email, so when using email_advanced validation
        // method, there is no need to use the default email valiation
        if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            return false;
        }

        list($localPart, $domain) = explode('@', $value);

        // Check if domain is on our "disposable" list
        if (in_array($domain, static::disposable())) {
            return false;
        }

        // Check if the domain has an actual MX record
        // Note: this is optional and can be disabled using email_advanced:false
        if (!empty($parameters) && !in_array('false', $parameters)) {

            if (!checkdnsrr($domain, 'MX')) {
                return false;
            }
        }

        return true;
    }

    public static function disposable()
    {
        return file(__DIR__.'/../support/disposable-emails.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    }
}
