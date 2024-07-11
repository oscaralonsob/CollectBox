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
    $domainUrl = CollectibleUrl::create("https://wiki.serenesforest.net/index.php/test");

    $this->assertNotNull($domainUrl);
  }

  public function testCreateFromRelative(): void
  {
    $domainUrl = CollectibleUrl::createFromRelative("test");

    $this->assertNotNull($domainUrl);
  }

  public function testCreateFromInvalid(): void
  {
    $this->expectException(CollectibleUrlInvalidException::class);

    CollectibleUrl::create("https://wiki.serenesforest.net/index.phl");
  }
}