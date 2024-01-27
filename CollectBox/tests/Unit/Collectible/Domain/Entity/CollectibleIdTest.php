<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Domain\Entity;

use App\Collectible\Domain\Entity\CollectibleId;
use App\Collectible\Domain\Exception\CollectibleIdInvalidException;
use PHPUnit\Framework\TestCase;

class CollectibleIdTest extends TestCase
{
  public function testCreateNormal(): void
  {
    $domainId = CollectibleId::create("B01-001N");

    $this->assertNotNull($domainId);
  }

  public function testCreateHighNormal(): void
  {
    $domainId = CollectibleId::create("B01-001HN");

    $this->assertNotNull($domainId);
  }

  public function testCreateRare(): void
  {
    $domainId = CollectibleId::create("B01-001R");

    $this->assertNotNull($domainId);
  }
  
  public function testCreateRarePlus(): void
  {
    $domainId = CollectibleId::create("B01-001R+");

    $this->assertNotNull($domainId);
  }
  
  public function testCreateSuperRare(): void
  {
    $domainId = CollectibleId::create("B01-001SR");

    $this->assertNotNull($domainId);
  }
  
  public function testCreatePlus(): void
  {
    $domainId = CollectibleId::create("B01-001SR+");

    $this->assertNotNull($domainId);
  }

  public function testCreateFromInvalid(): void
  {
    $this->expectException(CollectibleIdInvalidException::class);

    CollectibleId::create("B01-001L");
  }
}