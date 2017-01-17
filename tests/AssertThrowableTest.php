<?php

namespace VladaHejda;

use Error;
use Exception;
use PHPUnit_Framework_Exception;

class AssertThrowableTest extends \PHPUnit_Framework_TestCase
{

	public function testThrowable()
	{
		AssertException::assertThrowable(function() {
			throw new Exception();
		});

		AssertException::assertThrowable(function() {
			throw new Error();
		});
	}

	public function testCode()
	{
		$test = function() {
			throw new Exception(null, 110);
		};
		AssertException::assertThrowable($test, null, 110);

		$test = function() {
			throw new Error(null, 230);
		};
		AssertException::assertThrowable($test, null, 230);
	}

	public function testMessage()
	{
		$test = function() {
			throw new Exception('My message.');
		};
		AssertException::assertThrowable($test, null, null, 'My message.');

		$test = function() {
			throw new Error('Lorem ipsum');
		};
		AssertException::assertThrowable($test, null, null, 'Lorem ipsum');
	}

	public function testMessageContains()
	{
		$test = function() {
			throw new Exception('My message "Hello world".');
		};
		AssertException::assertThrowable($test, null, null, 'Hello world');

		$test = function() {
			throw new Error('My message "Lorem ipsum".');
		};
		AssertException::assertThrowable($test, null, null, 'Lorem ipsum');
	}

	public function testCodeAndMessage()
	{
		$test = function() {
			throw new Exception('My message.', 110);
		};
		AssertException::assertThrowable($test, null, 110, 'My message.');

		$test = function() {
			throw new Error('Lorem ipsum', 340);
		};
		AssertException::assertThrowable($test, null, 340, 'Lorem ipsum');
	}

	public function testReturn()
	{
		$expectedException = new Exception();
		$actualException = AssertException::assertThrowable(function() use ($expectedException) {
			throw $expectedException;
		});

		self::assertSame($expectedException, $actualException);
	}

	public function testInstanceOfError()
	{
		$this->expectException(PHPUnit_Framework_Exception::class);
		$this->expectExceptionMessage(sprintf('A class "%s" is not a Throwable.', NotException::class));

		$test = function () {
			throw new Exception();
		};
		AssertException::assertThrowable($test, NotException::class);
	}

}
