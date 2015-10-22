<?php

namespace VladaHejda;

use Exception;
use PHPUnit_Framework_Exception;

class AssertExceptionFailTest extends \PHPUnit_Framework_TestCase
{

	public function testBadCode()
	{
		$this->setExpectedException(PHPUnit_Framework_Exception::class, 'Failed asserting the code of thrown Exception.');

		$test = function() {
			throw new Exception(null, 110);
		};
		AssertException::assertException($test, null, 120);
	}

	public function testBadCodeOfClass()
	{
		$this->setExpectedException(PHPUnit_Framework_Exception::class, sprintf(
			'Failed asserting the code of thrown %s.',
			MyException::class
		));

		$test = function() {
			throw new MyException(null, 110);
		};
		AssertException::assertException($test, null, 120);
	}

	public function testBadMessage()
	{
		$this->setExpectedException(PHPUnit_Framework_Exception::class, 'Failed asserting the message of thrown Exception.');

		$test = function() {
			throw new Exception('Wrong message.');
		};
		AssertException::assertException($test, null, null, 'Right message.');
	}

	public function testBadMessageOfClass()
	{
		$this->setExpectedException(PHPUnit_Framework_Exception::class, sprintf(
			'Failed asserting the message of thrown %s.',
			MyException::class
		));

		$test = function() {
			throw new MyException('Wrong message.');
		};
		AssertException::assertException($test, null, null, 'Right message.');
	}

}
