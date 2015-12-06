# PhpUnitAssertException

> PhpUnit AssertException trait


## Install

```
$ composer require vladahejda/phpunit-assert-exception
```


## Usage

```php
<?php
class UsageTest extends PHPUnit_Framework_TestCase
{
	use VladaHejda\AssertException;

	public function testMultipleExceptionsAtOnce()
	{
		$this->assertException(function () {
			throw new InvalidArgumentException('Some Message', 10);
		});

		$this->assertException(function () {
			throw new InvalidArgumentException('Some Message', 10);
		}, InvalidArgumentException::class);

		$this->assertException(function () {
			throw new InvalidArgumentException('Some Message', 10);
		}, InvalidArgumentException::class, 10);

		$this->assertException(function () {
			throw new InvalidArgumentException('Some Message', 10);
		}, InvalidArgumentException::class, 10, 'Some Message');
	}
}
```
