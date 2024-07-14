<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Domain\Entity\ValueObject;

use App\Shared\Domain\Entity\ValueObject\NonEmptyString;
use App\Shared\Domain\Exception\NonEmptyStringInvalidException;
use PHPUnit\Framework\TestCase;

class NonEmptyStringTest extends TestCase
{
  public function testCreate(): void
  {
    $string = NonEmptyString::create("String test");

    $this->assertNotNull($string);
  }

  public function testCreateFromEmpty(): void
  {
    $this->expectException(NonEmptyStringInvalidException::class);

    NonEmptyString::create("");
  }

  public function testEqualsToWhenSame(): void
  {
    $value = "String test";
    $string1 = NonEmptyString::create($value);
    $string2 = NonEmptyString::create($value);

    $this->assertTrue($string1->equalsTo($string2));
  }

  public function testEqualsToWhenDifferent(): void
  {
    $string1 = NonEmptyString::create("String test 1");
    $string2 = NonEmptyString::create("String test 2");

    $this->assertFalse($string1->equalsTo($string2));
  }

  public function testValue(): void
  {
    $value = "String Test 1";
    $string = NonEmptyString::create($value);

    $this->assertEquals($value, $string->value());
  }
}