<?php

namespace VladaHejda;

use Exception;
use PHPUnit\Framework\TestCase;

class AssertExceptionTraitTest extends TestCase
{

	use AssertException;

	public function testException()
	{
		$test = function() {
			throw new Exception();
		};
		self::assertException($test);
	}

}
