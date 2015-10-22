<?php

namespace VladaHejda;

use Exception;
use PHPUnit_Framework_Exception;

class AssertExceptionClassFailTest extends \PHPUnit_Framework_TestCase
{

	public function testNothingThrown()
	{
		$this->setExpectedException(PHPUnit_Framework_Exception::class, 'Failed asserting that Exception was thrown.');

		$test = function() {
		};
		AssertException::assertException($test);
	}

	public function testNothingThrownWithSpecifiedClass()
	{
		$this->setExpectedException(PHPUnit_Framework_Exception::class, sprintf(
			'Failed asserting that Exception of type %s was thrown.',
			MyException::class
		));

		$test = function() {
		};
		AssertException::assertException($test, MyException::class);
	}

	public function testUndefinedClass()
	{
		$this->setExpectedException(PHPUnit_Framework_Exception::class, 'An exception of type "UndefinedException" does not exist.');

		$test = function() {
			throw new Exception();
		};
		AssertException::assertException($test, 'UndefinedException');
	}

	public function testNonException()
	{
		$this->setExpectedException(PHPUnit_Framework_Exception::class, sprintf(
			'A class "%s" is not an Exception.',
			NotException::class
		));

		$test = function() {
			throw new Exception();
		};
		AssertException::assertException($test, NotException::class);
	}

	public function testNotInstanceOf()
	{
		$this->setExpectedException(PHPUnit_Framework_Exception::class, 'Failed asserting the class of an exception.');

		$test = function() {
			throw new MyException();
		};
		AssertException::assertException($test, MyExceptionSubclass::class);
	}

	public function testNotInstanceOfWithCode()
	{
		$this->setExpectedException(PHPUnit_Framework_Exception::class, 'Failed asserting the class of an exception (code was 110).');

		$test = function() {
			throw new MyException(null, 110);
		};
		AssertException::assertException($test, MyExceptionSubclass::class);
	}

	public function testNotInstanceOfWithMessage()
	{
		$this->setExpectedException(PHPUnit_Framework_Exception::class, 'Failed asserting the class of an exception (message was "My message.").');

		$test = function() {
			throw new MyException('My message.');
		};
		AssertException::assertException($test, MyExceptionSubclass::class);
	}

	public function testNotInstanceOfWithCodeAndMessage()
	{
		$this->setExpectedException(PHPUnit_Framework_Exception::class, 'Failed asserting the class of an exception (code was 110, message was "My message.").');

		$test = function() {
			throw new MyException('My message.', 110);
		};
		AssertException::assertException($test, MyExceptionSubclass::class);
	}

}
