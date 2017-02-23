<?php declare(strict_types = 1);

namespace VladaHejda;

use Error;
use Exception;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use Throwable;

trait AssertException
{

	/**
	 * @param callable $test
	 * @param string|null $expectedThrowableClass
	 * @param string|int|null $expectedCode
	 * @param string|null $expectedMessage
	 * @return \Throwable
	 */
	public static function assertThrowable(
		callable $test,
		?string $expectedThrowableClass = Throwable::class,
		$expectedCode = null,
		?string $expectedMessage = null
	): Throwable
	{
		$expectedThrowableClass = self::fixThrowableClass($expectedThrowableClass, Throwable::class);

		try {
			$test();
		} catch (Throwable $throwable) {
			self::checkThrowableInstanceOf($throwable, $expectedThrowableClass, self::resolveThrowableCaption(Throwable::class));
			self::checkThrowableCode($throwable, $expectedCode);
			self::checkThrowableMessage($throwable, $expectedMessage);
			return $throwable;
		}

		self::failAssertingThrowable($expectedThrowableClass);
	}

	/**
	 * @param callable $test
	 * @param string|null $expectedExceptionClass
	 * @param string|int|null $expectedCode
	 * @param string|null $expectedMessage
	 * @return \Exception
	 */
	public static function assertException(
		callable $test,
		?string $expectedExceptionClass = Exception::class,
		$expectedCode = null,
		?string $expectedMessage = null
	): Exception
	{
		$expectedExceptionClass = self::fixThrowableClass($expectedExceptionClass, Exception::class);

		try {
			$test();
		} catch (Exception $exception) {
			self::checkThrowableInstanceOf($exception, $expectedExceptionClass, self::resolveThrowableCaption(Exception::class));
			self::checkThrowableCode($exception, $expectedCode);
			self::checkThrowableMessage($exception, $expectedMessage);
			return $exception;
		}

		self::failAssertingThrowable($expectedExceptionClass);
	}

	/**
	 * @param callable $test
	 * @param string|null $expectedErrorClass
	 * @param string|int|null $expectedCode
	 * @param string|null $expectedMessage
	 * @return \Error
	 */
	public static function assertError(
		callable $test,
		?string $expectedErrorClass = Error::class,
		$expectedCode = null,
		?string $expectedMessage = null
	): Error
	{
		$expectedErrorClass = self::fixThrowableClass($expectedErrorClass, Error::class);

		try {
			$test();
		} catch (Error $error) {
			self::checkThrowableInstanceOf($error, $expectedErrorClass, self::resolveThrowableCaption(Error::class));
			self::checkThrowableCode($error, $expectedCode);
			self::checkThrowableMessage($error, $expectedMessage);
			return $error;
		}

		self::failAssertingThrowable($expectedErrorClass);
	}

	private static function fixThrowableClass(?string $throwableClass, string $defaultClass = Throwable::class): string
	{
		if ($throwableClass === null) {
			$throwableClass = $defaultClass;

		} else {
			try {
				$reflection = new ReflectionClass($throwableClass);
				$throwableClass = $reflection->getName();
			} catch (ReflectionException $e) {
				TestCase::fail(sprintf('%s of type "%s" does not exist.', ucfirst(self::resolveThrowableCaption($defaultClass)), $throwableClass));
			}

			if (!$reflection->isInterface() && $throwableClass !== $defaultClass && !$reflection->isSubclassOf($defaultClass)) {
				TestCase::fail(sprintf('A class "%s" is not %s.', $throwableClass, self::resolveThrowableCaption($defaultClass)));
			}
		}

		return $throwableClass;
	}

	private static function checkThrowableInstanceOf(Throwable $throwable, string $expectedThrowableClass, string $expectedTypeCaption): void
	{
		$message = $throwable->getMessage();
		$code = $throwable->getCode();

		$details = '';
		if ($message !== '' && $code !== 0) {
			$details = sprintf(' (code was %s, message was "%s")', $code, $message); // code might be string also, e.g. in PDOException
		} elseif ($message !== '') {
			$details = sprintf(' (message was "%s")', $message);
		} elseif ($code !== 0) {
			$details = sprintf(' (code was %s)', $code);
		}

		$errorMessage = sprintf('Failed asserting the class of %s%s.', $expectedTypeCaption, $details);
		TestCase::assertInstanceOf($expectedThrowableClass, $throwable, $errorMessage);
	}

	/**
	 * @param \Throwable $throwable
	 * @param int|string|null $expectedCode
	 */
	private static function checkThrowableCode(Throwable $throwable, $expectedCode): void
	{
		if ($expectedCode !== null) {
			TestCase::assertEquals($expectedCode, $throwable->getCode(), sprintf('Failed asserting the code of thrown %s.', get_class($throwable)));
		}
	}

	private static function checkThrowableMessage(Throwable $throwable, string $expectedMessage = null): void
	{
		if ($expectedMessage !== null) {
			TestCase::assertContains($expectedMessage, $throwable->getMessage(), sprintf('Failed asserting the message of thrown %s.', get_class($throwable)));
		}
	}

	/**
	 * @param string $expectedThrowableClass
	 * @throws \PHPUnit\Framework\AssertionFailedError
	 */
	private static function failAssertingThrowable(string $expectedThrowableClass): void
	{
		TestCase::fail(sprintf('Failed asserting that %s was thrown.', self::resolveThrowableCaption($expectedThrowableClass)));
	}

	private static function resolveThrowableCaption(string $throwableClass): string
	{
		switch ($throwableClass) {
			case Exception::class:
				return 'an Exception';
				break;
			case Error::class:
				return 'an Error';
				break;
			case Throwable::class:
				return 'a Throwable';
			default:
				return $throwableClass;
		}
	}

}
