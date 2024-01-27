<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Domain\Entity;

use App\Collectible\Domain\Entity\CollectibleName;
use App\Collectible\Domain\Exception\CollectibleNameInvalidException;
use PHPUnit\Framework\TestCase;

class CollectibleNameTest extends TestCase
{
  public function testCreate(): void
  {
    $domainId = CollectibleName::create("Name test");

    $this->assertNotNull($domainId);
  }

  public function testCreateFromInvalid(): void
  {
    $this->expectException(CollectibleNameInvalidException::class);

    CollectibleName::create("this is for sure a string longer than 50 characters");
  }
}