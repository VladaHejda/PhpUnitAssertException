<?php

namespace VladaHejda;

use Exception;

class AssertExceptionFailTest extends \PHPUnit\Framework\TestCase
{

	public function testBadCode()
	{
		$this->expectException(\PHPUnit\Framework\Exception::class);
		$this->expectExceptionMessage('Failed asserting the code of thrown Exception.');

		$test = function() {
			throw new Exception(null, 110);
		};
		AssertException::assertException($test, null, 120);
	}

	public function testBadCodeOfClass()
	{
		$this->expectException(\PHPUnit\Framework\Exception::class);
		$this->expectExceptionMessage(sprintf(
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
		$this->expectException(\PHPUnit\Framework\Exception::class);
		$this->expectExceptionMessage('Failed asserting the message of thrown Exception.');

		$test = function() {
			throw new Exception('Wrong message.');
		};
		AssertException::assertException($test, null, null, 'Right message.');
	}

	public function testBadMessageOfClass()
	{
		$this->expectException(\PHPUnit\Framework\Exception::class);
		$this->expectExceptionMessage(sprintf(
			'Failed asserting the message of thrown %s.',
			MyException::class
		));

		$test = function() {
			throw new MyException('Wrong message.');
		};
		AssertException::assertException($test, null, null, 'Right message.');
	}

}
