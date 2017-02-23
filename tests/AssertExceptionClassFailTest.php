<?php declare(strict_types = 1);

namespace VladaHejda;

use Error;
use Exception;
use PHPUnit\Framework\TestCase;

class AssertExceptionClassFailTest extends TestCase
{

	public function testNothingThrown(): void
	{
		$this->expectException(\PHPUnit\Framework\Exception::class);
		$this->expectExceptionMessage('Failed asserting that Exception was thrown.');

		$test = function (): void {
		};
		AssertException::assertException($test);
	}

	public function testNothingThrownWithSpecifiedClass(): void
	{
		$this->expectException(\PHPUnit\Framework\Exception::class);
		$this->expectExceptionMessage(sprintf(
			'Failed asserting that %s was thrown.',
			MyException::class
		));

		$test = function (): void {
		};
		AssertException::assertException($test, MyException::class);
	}

	public function testUndefinedClass(): void
	{
		$this->expectException(\PHPUnit\Framework\Exception::class);
		$this->expectExceptionMessage('An exception of type "UndefinedException" does not exist.');

		$test = function (): void {
			throw new Exception();
		};
		AssertException::assertException($test, 'UndefinedException');
	}

	public function testNonException(): void
	{
		$this->expectException(\PHPUnit\Framework\Exception::class);
		$this->expectExceptionMessage(sprintf(
			'A class "%s" is not an Exception.',
			NotException::class
		));

		$test = function (): void {
			throw new Exception();
		};
		AssertException::assertException($test, NotException::class);
	}

	public function testNotInstanceOf(): void
	{
		$this->expectException(\PHPUnit\Framework\Exception::class);
		$this->expectExceptionMessage('Failed asserting the class of an exception.');

		$test = function (): void {
			throw new MyException();
		};
		AssertException::assertException($test, MyExceptionSubclass::class);
	}

	public function testNotInstanceOfWithCode(): void
	{
		$this->expectException(\PHPUnit\Framework\Exception::class);
		$this->expectExceptionMessage('Failed asserting the class of an exception (code was 110).');

		$test = function (): void {
			throw new MyException('', 110);
		};
		AssertException::assertException($test, MyExceptionSubclass::class);
	}

	public function testNotInstanceOfWithMessage(): void
	{
		$this->expectException(\PHPUnit\Framework\Exception::class);
		$this->expectExceptionMessage('Failed asserting the class of an exception (message was "My message.").');

		$test = function (): void {
			throw new MyException('My message.');
		};
		AssertException::assertException($test, MyExceptionSubclass::class);
	}

	public function testNotInstanceOfWithCodeAndMessage(): void
	{
		$this->expectException(\PHPUnit\Framework\Exception::class);
		$this->expectExceptionMessage('Failed asserting the class of an exception (code was 110, message was "My message.").');

		$test = function (): void {
			throw new MyException('My message.', 110);
		};
		AssertException::assertException($test, MyExceptionSubclass::class);
	}

	public function testError(): void
	{
		$this->expectException(Error::class);
		$this->expectExceptionMessage('My error');

		AssertException::assertException(function (): void {
			throw new Error('My error');
		});
	}

	public function testInstanceOfError(): void
	{
		$this->expectException(\PHPUnit\Framework\Exception::class);
		$this->expectExceptionMessage(sprintf('A class "%s" is not an Exception.', Error::class));

		$test = function (): void {
			throw new Error();
		};
		AssertException::assertException($test, Error::class);
	}

}
