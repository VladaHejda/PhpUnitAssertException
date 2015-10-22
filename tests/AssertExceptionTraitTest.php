<?php

namespace VladaHejda;

use Exception;

class AssertExceptionTraitTest extends \PHPUnit_Framework_TestCase
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
