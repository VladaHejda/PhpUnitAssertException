<?php declare(strict_types = 1);

namespace VladaHejda;

use Error;
use Exception;
use PHPUnit\Framework\TestCase;

class AssertExceptionClassFailTest extends TestCase
{

	public function testNothingThrown()
	{
		$this->expectException(\PHPUnit\Framework\Exception::class);
		$this->expectExceptionMessage('Failed asserting that Exception was thrown.');

		$test = function() {
		};
		AssertException::assertException($test);
	}

	public function testNothingThrownWithSpecifiedClass()
	{
		$this->expectException(\PHPUnit\Framework\Exception::class);
		$this->expectExceptionMessage(sprintf(
			'Failed asserting that %s was thrown.',
			MyException::class
		));

		$test = function() {
		};
		AssertException::assertException($test, MyException::class);
	}

	public function testUndefinedClass()
	{
		$this->expectException(\PHPUnit\Framework\Exception::class);
		$this->expectExceptionMessage('An exception of type "UndefinedException" does not exist.');

		$test = function() {
			throw new Exception();
		};
		AssertException::assertException($test, 'UndefinedException');
	}

	public function testNonException()
	{
		$this->expectException(\PHPUnit\Framework\Exception::class);
		$this->expectExceptionMessage(sprintf(
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
		$this->expectException(\PHPUnit\Framework\Exception::class);
		$this->expectExceptionMessage('Failed asserting the class of an exception.');

		$test = function() {
			throw new MyException();
		};
		AssertException::assertException($test, MyExceptionSubclass::class);
	}

	public function testNotInstanceOfWithCode()
	{
		$this->expectException(\PHPUnit\Framework\Exception::class);
		$this->expectExceptionMessage('Failed asserting the class of an exception (code was 110).');

		$test = function() {
			throw new MyException('', 110);
		};
		AssertException::assertException($test, MyExceptionSubclass::class);
	}

	public function testNotInstanceOfWithMessage()
	{
		$this->expectException(\PHPUnit\Framework\Exception::class);
		$this->expectExceptionMessage('Failed asserting the class of an exception (message was "My message.").');

		$test = function() {
			throw new MyException('My message.');
		};
		AssertException::assertException($test, MyExceptionSubclass::class);
	}

	public function testNotInstanceOfWithCodeAndMessage()
	{
		$this->expectException(\PHPUnit\Framework\Exception::class);
		$this->expectExceptionMessage('Failed asserting the class of an exception (code was 110, message was "My message.").');

		$test = function() {
			throw new MyException('My message.', 110);
		};
		AssertException::assertException($test, MyExceptionSubclass::class);
	}

	public function testError()
	{
		$this->expectException(Error::class);
		$this->expectExceptionMessage('My error');

		AssertException::assertException(function () {
			throw new Error('My error');
		});
	}

	public function testInstanceOfError()
	{
		$this->expectException(\PHPUnit\Framework\Exception::class);
		$this->expectExceptionMessage(sprintf('A class "%s" is not an Exception.', Error::class));

		$test = function () {
			throw new Error();
		};
		AssertException::assertException($test, Error::class);
	}

}
