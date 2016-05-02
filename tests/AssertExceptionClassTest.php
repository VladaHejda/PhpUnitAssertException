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
		$this->assertInstanceOf(Exception::class, AssertException::assertException($test, null));
	}

	public function testClass()
	{
		$test = function() {
			throw new MyException();
		};
		$this->assertInstanceOf(MyException::class, AssertException::assertException($test, MyException::class));
	}

	public function testSubclass()
	{
		$test = function() {
			throw new MyException();
		};
		$this->assertInstanceOf(MyException::class, AssertException::assertException($test));
	}

	public function testSubclassOfSubclass()
	{
		$test = function() {
			throw new MyExceptionSubclass();
		};
		$this->assertInstanceOf(MyExceptionSubclass::class, AssertException::assertException($test, MyException::class));
	}

	public function testLowercaseClass()
	{
		$test = function() {
			throw new Exception();
		};
		$this->assertInstanceOf(Exception::class, AssertException::assertException($test, 'exception'));
	}

	public function testFqn()
	{
		$test = function() {
			throw new Exception();
		};
		$this->assertInstanceOf(Exception::class, AssertException::assertException($test, '\Exception'));
	}

	public function testLowercaseFqn()
	{
		$test = function() {
			throw new Exception();
		};
		$this->assertInstanceOf(Exception::class, AssertException::assertException($test, '\exception'));
	}

	public function testInterface()
	{
		$test = function() {
			throw new MyExceptionImplementsInterface();
		};
		$this->assertInstanceOf(MyExceptionImplementsInterface::class, AssertException::assertException($test, MyExceptionInterface::class));
	}

}
