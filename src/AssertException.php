<?php declare(strict_types = 1);

namespace VladaHejda;

use Error;
use Exception;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase;
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
			self::checkThrowableInstanceOf($throwable, $expectedThrowableClass);
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
			self::checkThrowableInstanceOf($exception, $expectedExceptionClass);
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
			self::checkThrowableInstanceOf($error, $expectedErrorClass);
			self::checkThrowableCode($error, $expectedCode);
			self::checkThrowableMessage($error, $expectedMessage);
			return $error;
		}

		self::failAssertingThrowable($expectedErrorClass);
	}

	private static function fixThrowableClass(?string $exceptionClass, string $defaultClass = Throwable::class): string
	{
		if ($exceptionClass === null) {
			$exceptionClass = $defaultClass;

		} else {
			try {
				$reflection = new ReflectionClass($exceptionClass);
				$exceptionClass = $reflection->getName();
			} catch (ReflectionException $e) {
				PHPUnit_Framework_TestCase::fail(sprintf('An exception of type "%s" does not exist.', $exceptionClass));
			}

			if (!$reflection->isInterface() && $exceptionClass !== $defaultClass && !$reflection->isSubclassOf($defaultClass)) {
				switch ($defaultClass) {
					case Exception::class:
						$expectedType = 'an Exception';
						break;
					case Error::class:
						$expectedType = 'an Error';
						break;
					default:
						$expectedType = 'a Throwable';
				}
				PHPUnit_Framework_TestCase::fail(sprintf('A class "%s" is not %s.', $exceptionClass, $expectedType));
			}
		}

		return $exceptionClass;
	}

	private static function checkThrowableInstanceOf(Throwable $throwable, string $expectedThrowableClass)
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

		$errorMessage = sprintf('Failed asserting the class of an exception%s.', $details);
		PHPUnit_Framework_TestCase::assertInstanceOf($expectedThrowableClass, $throwable, $errorMessage);
	}

	/**
	 * @param \Throwable $exception
	 * @param int|string|null $expectedCode
	 */
	private static function checkThrowableCode(Throwable $exception, $expectedCode)
	{
		if ($expectedCode !== null) {
			PHPUnit_Framework_TestCase::assertEquals($expectedCode, $exception->getCode(), sprintf('Failed asserting the code of thrown %s.', get_class($exception)));
		}
	}

	private static function checkThrowableMessage(Throwable $throwable, string $expectedMessage = null)
	{
		if ($expectedMessage !== null) {
			PHPUnit_Framework_TestCase::assertContains($expectedMessage, $throwable->getMessage(), sprintf('Failed asserting the message of thrown %s.', get_class($throwable)));
		}
	}

	/**
	 * @param string $expectedThrowableClass
	 * @throws \PHPUnit_Framework_AssertionFailedError
	 */
	private static function failAssertingThrowable(string $expectedThrowableClass)
	{
		PHPUnit_Framework_TestCase::fail(sprintf('Failed asserting that %s was thrown.', $expectedThrowableClass));
	}

}
