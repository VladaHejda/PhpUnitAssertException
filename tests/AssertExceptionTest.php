<?php declare(strict_types = 1);

namespace VladaHejda;

use Exception;
use PHPUnit\Framework\TestCase;

class AssertExceptionTest extends TestCase
{

	public function testException(): void
	{
		AssertException::assertException(function (): void {
			throw new Exception();
		});
	}

	public function testCode(): void
	{
		$test = function (): void {
			throw new Exception('', 110);
		};
		AssertException::assertException($test, null, 110);
	}

	public function testMessage(): void
	{
		$test = function (): void {
			throw new Exception('My message.');
		};
		AssertException::assertException($test, null, null, 'My message.');
	}

	public function testMessageContains(): void
	{
		$test = function (): void {
			throw new Exception('My message "Hello world".');
		};
		AssertException::assertException($test, null, null, 'Hello world');
	}

	public function testCodeAndMessage(): void
	{
		$test = function (): void {
			throw new Exception('My message.', 110);
		};
		AssertException::assertException($test, null, 110, 'My message.');
	}

	public function testReturn(): void
	{
		$expectedException = new Exception();
		$actualException = AssertException::assertException(function () use ($expectedException): void {
			throw $expectedException;
		});

		self::assertSame($expectedException, $actualException);
	}

}
