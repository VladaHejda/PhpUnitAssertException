# PhpUnitAssertException

`AssertException` is a trait, so it can be easily used in your test case.

- For PHP 7.1 compatibility require version `1.2.0`.
- For PHP 7 compatibility require version `1.1.0`.
- For PHP 5 compatibility require version `1.0.0`.

## Install

```
$ composer require vladahejda/phpunit-assert-exception
```


## Usage

```php
<?php

class MyTest extends PHPUnit_Framework_TestCase
{
	use VladaHejda\AssertException;

	public function testMultipleExceptionsAtOnce()
	{
		$test = function () {
			// here comes some test stuff of your unit (tested class)
			// which you expect that will throw an Exception
			throw new InvalidArgumentException('Some message 12345', 100);
		};

		// just test if function throws an Exception
		$this->assertException($test); // pass

		// test class of an Exception
		$this->assertException($test, InvalidArgumentException::class); // pass

		// test Exception code
		$this->assertException($test, null, 100); // pass

		// test Exception message
		$this->assertException($test, null, null, 'Some message 12345'); // pass
		$this->assertException($test, null, null, 'Some message'); // also pass, because it checks on substring level

		// test all
		$this->assertException($test, InvalidArgumentException::class, 100, 'Some message 12345'); // pass

		// and here some failing tests
		// wrong class
		$this->assertException($test, ErrorException::class); // fail
		// wrong code
		$this->assertException($test, InvalidArgumentException::class, 200); // fail
		// wrong message
		$this->assertException($test, InvalidArgumentException::class, 100, 'Bad message'); // fail
	}
}
```

Also see an `assertError` and `assertThrowable` methods, which tests if PHP internal `Error` was thrown, or any `Throwable` respectively.
