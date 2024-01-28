<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Domain\Entity;

use App\Collectible\Domain\Entity\CollectibleCode;
use App\Collectible\Domain\Exception\CollectibleCodeInvalidException;
use PHPUnit\Framework\TestCase;

class CollectibleCodeTest extends TestCase
{
  public function testCreateNormal(): void
  {
    $domainId = CollectibleCode::create("B01-001N");

    $this->assertNotNull($domainId);
  }

  public function testCreateHighNormal(): void
  {
    $domainId = CollectibleCode::create("B01-001HN");

    $this->assertNotNull($domainId);
  }

  public function testCreateRare(): void
  {
    $domainId = CollectibleCode::create("B01-001R");

    $this->assertNotNull($domainId);
  }
  
  public function testCreateRarePlus(): void
  {
    $domainId = CollectibleCode::create("B01-001R+");

    $this->assertNotNull($domainId);
  }
  
  public function testCreateSuperRare(): void
  {
    $domainId = CollectibleCode::create("B01-001SR");

    $this->assertNotNull($domainId);
  }
  
  public function testCreatePlus(): void
  {
    $domainId = CollectibleCode::create("B01-001SR+");

    $this->assertNotNull($domainId);
  }

  public function testCreateFromInvalid(): void
  {
    $this->expectException(CollectibleCodeInvalidException::class);

    CollectibleCode::create("B01-001L");
  }
}