<?php

use Clumsy\Utils\Library\FieldFactory;

class FieldFactoryTest extends PHPUnit_Framework_TestCase
{
    private $factory;

    public function setUp()
    {
        $this->factory = new FieldFactory;
    }

    public function testMacroable()
    {
        $this->factory->macro('test', function ($name) {
            return $name;
        });

        $this->assertEquals('Clumsy', $this->factory->test('Clumsy'));
    }
}
