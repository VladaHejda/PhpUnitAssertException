<?php

namespace VladaHejda;

use Exception;

class AssertExceptionTest extends \PHPUnit_Framework_TestCase
{

	public function testException()
	{
		AssertException::assertException(function() {
			throw new Exception();
		});
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

	public function testReturn()
	{
		$expectedException = new Exception();
		$actualException = AssertException::assertException(function() use ($expectedException) {
			throw $expectedException;
		});

		self::assertSame($expectedException, $actualException);
	}

}
