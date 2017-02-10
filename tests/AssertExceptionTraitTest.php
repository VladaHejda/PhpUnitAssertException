<?php

namespace VladaHejda;

use Exception;

class AssertExceptionTraitTest extends \PHPUnit\Framework\TestCase
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
