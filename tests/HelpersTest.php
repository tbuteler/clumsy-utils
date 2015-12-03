<?php

class HelpersTest extends PHPUnit_Framework_TestCase
{

    public function testArrayIsAssociative()
    {
        $not_array = 'value';
        $not_associative = ['value'];
        $associative = ['key' => 'value'];
        $multi_associative = ['key' => ['key' => 'value']];
        $this->assertFalse(array_is_associative($not_array));
        $this->assertFalse(array_is_associative($not_associative));
        $this->assertTrue(array_is_associative($associative));
        $this->assertTrue(array_is_associative($multi_associative));
    }

    public function testArrayIsNested()
    {
        $not_array = 'value';
        $not_nested = ['value'];
        $associative = ['key' => 'value'];
        $nested = ['key' => ['value']];
        $nested_associative = ['key' => ['key' => 'value']];
        $this->assertFalse(array_is_nested($not_array));
        $this->assertFalse(array_is_nested($not_nested));
        $this->assertFalse(array_is_nested($associative));
        $this->assertTrue(array_is_nested($nested));
        $this->assertTrue(array_is_nested($nested_associative));
    }

    public function testFloatAsInt()
    {
        $floats = [
            '1.20',
            2.5999999,
            9.95,
        ];

        $integers = [
            120,
            260,
            995,
        ];

        $converted = array_map('floatAsInt', $floats);

        $this->assertTrue((bool)count(array_filter($converted, function ($number) {
            return is_int($number);
        })));

        $this->assertEquals($converted, $integers);
    }
}
