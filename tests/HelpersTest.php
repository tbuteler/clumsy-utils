<?php

class HelpersTest extends PHPUnit_Framework_TestCase {

	public function testArrayIsAssociative()
	{
		$not_array = 'value';
		$not_associative = array('value');
		$associative = array('key' => 'value');
		$multi_associative = array('key' => array('key' => 'value'));
		$this->assertFalse(array_is_associative($not_array));
		$this->assertFalse(array_is_associative($not_associative));
		$this->assertTrue(array_is_associative($associative));
		$this->assertTrue(array_is_associative($multi_associative));
	}

	public function testArrayIsNested()
	{
		$not_array = 'value';
		$not_nested = array('value');
		$associative = array('key' => 'value');
		$nested = array('key' => array('value'));
		$nested_associative = array('key' => array('key' => 'value'));
		$this->assertFalse(array_is_nested($not_array));
		$this->assertFalse(array_is_nested($not_nested));
		$this->assertFalse(array_is_nested($associative));
		$this->assertTrue(array_is_nested($nested));
		$this->assertTrue(array_is_nested($nested_associative));
	}
}