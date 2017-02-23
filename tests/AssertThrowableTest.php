<?php declare(strict_types = 1);

namespace VladaHejda;

use Error;
use Exception;
use PHPUnit\Framework\TestCase;

class AssertThrowableTest extends TestCase
{

	public function testThrowable(): void
	{
		AssertException::assertThrowable(function (): void {
			throw new Exception();
		});

		AssertException::assertThrowable(function (): void {
			throw new Error();
		});
	}

	public function testCode(): void
	{
		$test = function (): void {
			throw new Exception('', 110);
		};
		AssertException::assertThrowable($test, null, 110);

		$test = function (): void {
			throw new Error('', 230);
		};
		AssertException::assertThrowable($test, null, 230);
	}

	public function testMessage(): void
	{
		$test = function (): void {
			throw new Exception('My message.');
		};
		AssertException::assertThrowable($test, null, null, 'My message.');

		$test = function (): void {
			throw new Error('Lorem ipsum');
		};
		AssertException::assertThrowable($test, null, null, 'Lorem ipsum');
	}

	public function testMessageContains(): void
	{
		$test = function (): void {
			throw new Exception('My message "Hello world".');
		};
		AssertException::assertThrowable($test, null, null, 'Hello world');

		$test = function (): void {
			throw new Error('My message "Lorem ipsum".');
		};
		AssertException::assertThrowable($test, null, null, 'Lorem ipsum');
	}

	public function testCodeAndMessage(): void
	{
		$test = function (): void {
			throw new Exception('My message.', 110);
		};
		AssertException::assertThrowable($test, null, 110, 'My message.');

		$test = function (): void {
			throw new Error('Lorem ipsum', 340);
		};
		AssertException::assertThrowable($test, null, 340, 'Lorem ipsum');
	}

	public function testReturn(): void
	{
		$expectedException = new Exception();
		$actualException = AssertException::assertThrowable(function () use ($expectedException): void {
			throw $expectedException;
		});

		self::assertSame($expectedException, $actualException);
	}

	public function testInstanceOfError(): void
	{
		$this->expectException(\PHPUnit\Framework\Exception::class);
		$this->expectExceptionMessage(sprintf('A class "%s" is not a Throwable.', NotException::class));

		$test = function (): void {
			throw new Exception();
		};
		AssertException::assertThrowable($test, NotException::class);
	}

}
