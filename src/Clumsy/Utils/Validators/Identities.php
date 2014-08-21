<?php namespace Clumsy\Utils\Validators;

class Identities {

    public $types = array(

        'pt_nif' => 'Clumsy\Utils\Validators\PT\Identities@nif',
    );

    public function validate($attribute, $value, $parameters)
    {
        $type = head($parameters);

        if (!$type)
        {
            throw new \Exception('Cannot use "id" validator without specifying parameters (i.e. "id:code")');
        }

        list($object, $method) = explode('@', $this->types[$type]);

        with(new $object)->$method($attribute, $value, $parameters);
    }
}