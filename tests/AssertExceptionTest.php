<?php

namespace VladaHejda;

use Exception;

class AssertExceptionTest extends \PHPUnit_Framework_TestCase
{

	public function testException()
	{
		$test = function() {
			throw new Exception();
		};
		AssertException::assertException($test);
	}

	public function testCode()
	{
		$test = function() {
			throw new Exception(null, 110);
		};
		AssertException::assertException($test, null, 110);
	}

	public function testMessage()
	{
		$test = function() {
			throw new Exception('My message.');
		};
		AssertException::assertException($test, null, null, 'My message.');
	}

	public function testMessageContains()
	{
		$test = function() {
			throw new Exception('My message "Hello world".');
		};
		AssertException::assertException($test, null, null, 'Hello world');
	}

	public function testCodeAndMessage()
	{
		$test = function() {
			throw new Exception('My message.', 110);
		};
		AssertException::assertException($test, null, 110, 'My message.');
	}

}
