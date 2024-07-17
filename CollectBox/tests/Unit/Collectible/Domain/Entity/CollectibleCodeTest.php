<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Domain\Entity;

use App\Collectible\Domain\Entity\CollectibleCode;
use App\Collectible\Domain\Exception\CollectibleCodeInvalidException;
use Tests\Infrastructure\TestCase\BaseTestCase;

class CollectibleCodeTest extends BaseTestCase
{
  public function testCreateNormal(): void
  {
    $collectibleCode = CollectibleCode::create("B01-001N");

    $this->assertNotNull($collectibleCode);
  }

  public function testCreateHighNormal(): void
  {
    $collectibleCode = CollectibleCode::create("B01-001HN");

    $this->assertNotNull($collectibleCode);
  }
  
  public function testEspecialVerions(): void
  {
    $collectibleCode = CollectibleCode::create("B01-001X");

    $this->assertNotNull($collectibleCode);
  }

  public function testCreateRare(): void
  {
    $collectibleCode = CollectibleCode::create("B01-001R");

    $this->assertNotNull($collectibleCode);
  }
  
  public function testCreateRarePlus(): void
  {
    $collectibleCode = CollectibleCode::create("B01-001R+");

    $this->assertNotNull($collectibleCode);
  }
  
  public function testCreateSuperRare(): void
  {
    $collectibleCode = CollectibleCode::create("B01-001SR");

    $this->assertNotNull($collectibleCode);
  }
  
  public function testCreatePlus(): void
  {
    $collectibleCode = CollectibleCode::create("B01-001SR+");

    $this->assertNotNull($collectibleCode);
  }

  public function testCreateFromInvalid(): void
  {
    $this->expectException(CollectibleCodeInvalidException::class);

    CollectibleCode::create("B01-001L");
  }
}