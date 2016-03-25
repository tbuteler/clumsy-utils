<?php

/*
 |--------------------------------------------------------------------------
 | Clumsy Utils Field settings
 |--------------------------------------------------------------------------
 |
 |
 */

return [

    /*
     |--------------------------------------------------------------------------
     | Smart guessing of field attributes
     |--------------------------------------------------------------------------
     |
     | If enabled, the package will attempt to configure your fields based on
     | best-practices using its name and type as a starting point
     |
     */

    'guess-attributes' => true,

    /*
     |--------------------------------------------------------------------------
     | Attribute guesses by input type
     |--------------------------------------------------------------------------
     */

    'type:text'     => 'autocorrect:off',
    'type:textarea' => 'autocorrect|spellcheck|autocapitalize:sentences',
    'type:tel'      => 'autocomplete:tel',

    /*
     |--------------------------------------------------------------------------
     | Attribute guesses by input name
     |--------------------------------------------------------------------------
     */

    'name:name'           => 'autocomplete:name|autocapitalize:words',
    'name:organization'   => 'autocomplete:organization|autocapitalize:words',
    'name:fname'          => 'autocomplete:given-name|autocaptitalize:words',
    'name:first_name'     => 'autocomplete:given-name|autocaptitalize:words',
    'name:mname'          => 'autocomplete:additional-name|autocaptitalize:words',
    'name:middle_name'    => 'autocomplete:additional-name|autocaptitalize:words',
    'name:lname'          => 'autocomplete:family-name|autocaptitalize:words',
    'name:last_name'      => 'autocomplete:family-name|autocaptitalize:words',
    'name:ccname'         => 'autocomplete:cc-name|autocapitalize:words',
    'name:cardnumber'     => 'autocomplete:cc-number|digits',
    'name:cvc'            => 'autocomplete:cc-csc|digits',
    'name:ccmonth'        => 'autocomplete:cc-exp-month|digits',
    'name:ccyear'         => 'autocomplete:cc-exp-year|digits',
    'name:exp-date'       => 'autocomplete:cc-exp',
    'name:card-type'      => 'autocomplete:cc-type',
    'name:bday'           => 'autocomplete:bday',
    'name:birthday'       => 'autocomplete:bday',
    'name:bday-day'       => 'autocomplete:bday-day|digits',
    'name:bday-month'     => 'autocomplete:bday-month|digits',
    'name:bday-year'      => 'autocomplete:bday-year|digits',
    'name:postal'         => 'autocomplete:postal-code',
    'name:postal-code'    => 'autocomplete:postal-code',
    'name:address-level4' => 'autocomplete:address-level4',
    'name:address-level3' => 'autocomplete:address-level3',
    'name:address-level2' => 'autocomplete:address-level2',
    'name:city'           => 'autocomplete:address-level2',
    'name:address-level1' => 'autocomplete:address-level1',

];
