<?php

use Clumsy\Utils\Library\HTTP;

class HTTPTest extends PHPUnit_Framework_TestCase
{
    private $http;

    public function setUp()
    {
        $this->http = new HTTP;
    }

    public function testQueryStringAdd()
    {
        $this->assertEquals('http://url.com?foo', $this->http->queryStringAdd('http://url.com', 'foo'));
        $this->assertEquals('http://url.com?foo=', $this->http->queryStringAdd('http://url.com', 'foo', ''));
        $this->assertEquals('http://url.com?foo=bar', $this->http->queryStringAdd('http://url.com', 'foo', 'bar'));
        $this->assertEquals('http://url.com?foo&bar', $this->http->queryStringAdd('http://url.com?foo', 'bar'));
        $this->assertEquals('http://url.com?foo=bar&hey', $this->http->queryStringAdd('http://url.com?foo=bar', 'hey'));
        $this->assertEquals('http://url.com?foo=bar&hey=ho', $this->http->queryStringAdd('http://url.com?foo=bar', 'hey', 'ho'));
        $this->assertEquals('http://url.com?foo', $this->http->queryStringAdd('http://url.com?foo=bar', ['foo' => null]));
        $this->assertEquals('http://url.com?foo=baz', $this->http->queryStringAdd('http://url.com?foo=bar', ['foo' => 'baz']));
        $this->assertEquals('http://url.com?foo&hey=ho', $this->http->queryStringAdd('http://url.com?foo=bar', ['foo' => null, 'hey' => 'ho']));
    }

    public function testQueryStringRemove()
    {
        $this->assertEquals('http://url.com', $this->http->queryStringRemove('http://url.com?foo', 'foo'));
        $this->assertEquals('http://url.com', $this->http->queryStringRemove('http://url.com?foo=', 'foo'));
        $this->assertEquals('http://url.com', $this->http->queryStringRemove('http://url.com?foo=bar', ['foo', 'bar']));
        $this->assertEquals('http://url.com?foo', $this->http->queryStringRemove('http://url.com?foo&bar', 'bar'));
        $this->assertEquals('http://url.com?foo=bar', $this->http->queryStringRemove('http://url.com?foo=bar&hey', 'hey'));
        $this->assertEquals('http://url.com?hey', $this->http->queryStringRemove('http://url.com?foo=bar&hey', 'foo'));
        $this->assertEquals('http://url.com', $this->http->queryStringRemove('http://url.com?foo=bar&hey=ho', ['foo', 'hey']));
    }
}
