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
    $domainId = NonEmptyString::create("String test");

    $this->assertNotNull($domainId);
  }

  public function testCreateFromEmpty(): void
  {
    $this->expectException(NonEmptyStringInvalidException::class);

    NonEmptyString::create("");
  }

  public function testEqualsToWhenSame(): void
  {
    $value = "String test";
    $domainId1 = NonEmptyString::create($value);
    $domainId2 = NonEmptyString::create($value);

    $this->assertTrue($domainId1->equalsTo($domainId2));
  }

  public function testEqualsToWhenDifferent(): void
  {
    $domainId1 = NonEmptyString::create("String test 1");
    $domainId2 = NonEmptyString::create("String test 2");

    $this->assertFalse($domainId1->equalsTo($domainId2));
  }

  public function testValue(): void
  {
    $value = "String Test 1";
    $domainId = NonEmptyString::create($value);

    $this->assertEquals($value, $domainId->value());
  }
}