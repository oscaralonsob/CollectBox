<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Domain\Entity;

use App\Collectible\Domain\Entity\CollectibleUrl;
use App\Collectible\Domain\Exception\CollectibleUrlInvalidException;
use PHPUnit\Framework\TestCase;

class CollectibleUrlTest extends TestCase
{
  public function testCreate(): void
  {
    $domainId = CollectibleUrl::create("https://wiki.serenesforest.net/index.php/test");

    $this->assertNotNull($domainId);
  }

  public function testCreateFromInvalid(): void
  {
    $this->expectException(CollectibleUrlInvalidException::class);

    CollectibleUrl::create("https://wiki.serenesforest.net/index.phl");
  }
}