<?php

namespace VladaHejda;

use Exception;

class AssertExceptionClassTest extends \PHPUnit_Framework_TestCase
{

	public function testDefault()
	{
		$test = function() {
			throw new Exception();
		};
		AssertException::assertException($test, null);
	}

	public function testClass()
	{
		$test = function() {
			throw new MyException();
		};
		AssertException::assertException($test, MyException::class);
	}

	public function testSubclass()
	{
		$test = function() {
			throw new MyException();
		};
		AssertException::assertException($test);
	}

	public function testSubclassOfSubclass()
	{
		$test = function() {
			throw new MyExceptionSubclass();
		};
		AssertException::assertException($test, MyException::class);
	}

	public function testLowercaseClass()
	{
		$test = function() {
			throw new Exception();
		};
		AssertException::assertException($test, 'exception');
	}

	public function testFqn()
	{
		$test = function() {
			throw new Exception();
		};
		AssertException::assertException($test, '\Exception');
	}

	public function testLowercaseFqn()
	{
		$test = function() {
			throw new Exception();
		};
		AssertException::assertException($test, '\exception');
	}

	public function testInterface()
	{
		$test = function() {
			throw new MyExceptionImplementsInterface();
		};
		AssertException::assertException($test, MyExceptionInterface::class);
	}

}
