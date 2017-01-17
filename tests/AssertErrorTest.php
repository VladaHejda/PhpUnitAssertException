<?php

namespace VladaHejda;

use Error;
use Exception;

class AssertErrorTest extends \PHPUnit_Framework_TestCase
{

	public function testError()
	{
		AssertException::assertError(function() {
			throw new Error();
		});
	}

	public function testCode()
	{
		$test = function() {
			throw new Error(null, 110);
		};
		AssertException::assertError($test, null, 110);
	}

	public function testMessage()
	{
		$test = function() {
			throw new Error('My message.');
		};
		AssertException::assertError($test, null, null, 'My message.');
	}

	public function testMessageContains()
	{
		$test = function() {
			throw new Error('My message "Hello world".');
		};
		AssertException::assertError($test, null, null, 'Hello world');
	}

	public function testCodeAndMessage()
	{
		$test = function() {
			throw new Error('My message.', 110);
		};
		AssertException::assertError($test, null, 110, 'My message.');
	}

	public function testReturn()
	{
		$expectedError = new Error();
		$actualError = AssertException::assertError(function() use ($expectedError) {
			throw $expectedError;
		});

		self::assertSame($expectedError, $actualError);
	}

	public function testException()
	{
		$this->expectException(Exception::class);
		$this->expectExceptionMessage('My exception');

		AssertException::assertError(function () {
			throw new Exception('My exception');
		});
	}

}
