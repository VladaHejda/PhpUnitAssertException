<?php declare(strict_types = 1);

namespace VladaHejda;

use Error;
use Exception;
use PHPUnit\Framework\TestCase;

class AssertErrorTest extends TestCase
{

	public function testError(): void
	{
		AssertException::assertError(function (): void {
			throw new Error();
		});
	}

	public function testCode(): void
	{
		$test = function (): void {
			throw new Error('', 110);
		};
		AssertException::assertError($test, null, 110);
	}

	public function testMessage(): void
	{
		$test = function (): void {
			throw new Error('My message.');
		};
		AssertException::assertError($test, null, null, 'My message.');
	}

	public function testMessageContains(): void
	{
		$test = function (): void {
			throw new Error('My message "Hello world".');
		};
		AssertException::assertError($test, null, null, 'Hello world');
	}

	public function testCodeAndMessage(): void
	{
		$test = function (): void {
			throw new Error('My message.', 110);
		};
		AssertException::assertError($test, null, 110, 'My message.');
	}

	public function testReturn(): void
	{
		$expectedError = new Error();
		$actualError = AssertException::assertError(function () use ($expectedError): void {
			throw $expectedError;
		});

		self::assertSame($expectedError, $actualError);
	}

	public function testException(): void
	{
		$this->expectException(Exception::class);
		$this->expectExceptionMessage('My exception');

		AssertException::assertError(function (): void {
			throw new Exception('My exception');
		});
	}

}
