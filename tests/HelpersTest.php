<?php

class HelpersTest extends PHPUnit_Framework_TestCase {

	public function testIsAssociativeArray()
	{
		$not_array = 'value';
		$not_associative = array('value');
		$associative = array('key' => 'value');
		$multi_associative = array('key' => array('key' => 'value'));
		$this->assertFalse(is_associative($not_array));
		$this->assertFalse(is_associative($not_associative));
		$this->assertTrue(is_associative($associative));
		$this->assertTrue(is_associative($multi_associative));
	}

	public function testIsNestedArray()
	{
		$not_array = 'value';
		$not_nested = array('value');
		$associative = array('key' => 'value');
		$nested = array('key' => array('value'));
		$nested_associative = array('key' => array('key' => 'value'));
		$this->assertFalse(is_nested($not_array));
		$this->assertFalse(is_nested($not_nested));
		$this->assertFalse(is_nested($associative));
		$this->assertTrue(is_nested($nested));
		$this->assertTrue(is_nested($nested_associative));
	}
}