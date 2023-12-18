<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Domain\Entity\ValueObject;

use App\Shared\Domain\Entity\ValueObject\DomainId;
use App\Shared\Domain\Exception\UuidInvalidException;
use PHPUnit\Framework\TestCase;

class DomainIdTest extends TestCase
{
  public function testCreateFromString(): void
  {
    $domainId = DomainId::create("24c1aebe-9c22-4144-ad18-6555da9d1341");

    $this->assertNotNull($domainId);
  }

  public function testCreateFromInvalidString(): void
  {
    $this->expectException(UuidInvalidException::class);

   DomainId::create("Invalid Uuid");
  }

  public function testCreateRandom(): void
  {
    $domainId = DomainId::createRandom();

    $this->assertNotNull($domainId);
  }

  public function testEqualsToWhenSame(): void
  {
    $value = "24c1aebe-9c22-4144-ad18-6555da9d1341";
    $domainId1 = DomainId::create($value);
    $domainId2 = DomainId::create($value);

    $this->assertTrue($domainId1->equalsTo($domainId2));
  }

  public function testEqualsToWhenDifferent(): void
  {
    $domainId1 = DomainId::create("24c1aebe-9c22-4144-ad18-6555da9d1341");
    $domainId2 = DomainId::create("8715239f-2fdd-472e-a29a-81f7aac782cb");

    $this->assertFalse($domainId1->equalsTo($domainId2));
  }

  public function testValue(): void
  {
    $value = "24c1aebe-9c22-4144-ad18-6555da9d1341";
    $domainId = DomainId::create($value);

    $this->assertEquals($value, $domainId->value());
  }
}