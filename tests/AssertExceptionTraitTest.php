<?php declare(strict_types = 1);

namespace VladaHejda;

use Exception;
use PHPUnit\Framework\TestCase;

class AssertExceptionTraitTest extends TestCase
{

	use AssertException;

	public function testException(): void
	{
		$test = function (): void {
			throw new Exception();
		};
		self::assertException($test);
	}

}
