<?php declare(strict_types = 1);

namespace VladaHejda;

use Exception;
use PHPUnit\Framework\TestCase;

class AssertExceptionClassTest extends TestCase
{

	public function testDefault(): void
	{
		$test = function (): void {
			throw new Exception();
		};
		AssertException::assertException($test, null);
	}

	public function testClass(): void
	{
		$test = function (): void {
			throw new MyException();
		};
		AssertException::assertException($test, MyException::class);
	}

	public function testSubclass(): void
	{
		$test = function (): void {
			throw new MyException();
		};
		AssertException::assertException($test);
	}

	public function testSubclassOfSubclass(): void
	{
		$test = function (): void {
			throw new MyExceptionSubclass();
		};
		AssertException::assertException($test, MyException::class);
	}

	public function testLowercaseClass(): void
	{
		$test = function (): void {
			throw new Exception();
		};
		AssertException::assertException($test, 'exception');
	}

	public function testFqn(): void
	{
		$test = function (): void {
			throw new Exception();
		};
		AssertException::assertException($test, '\Exception');
	}

	public function testLowercaseFqn(): void
	{
		$test = function (): void {
			throw new Exception();
		};
		AssertException::assertException($test, '\exception');
	}

	public function testInterface(): void
	{
		$test = function (): void {
			throw new MyExceptionImplementsInterface();
		};
		AssertException::assertException($test, MyExceptionInterface::class);
	}

}
