<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Domain\Entity;

use App\Collectible\Domain\Entity\CollectibleName;
use App\Collectible\Domain\Exception\CollectibleNameInvalidException;
use Tests\Infrastructure\TestCase\BaseTestCase;

class CollectibleNameTest extends BaseTestCase
{
  public function testCreate(): void
  {
    $domainName = CollectibleName::create("Name test");

    $this->assertNotNull($domainName);
  }

  public function testCreateFromInvalid(): void
  {
    $this->expectException(CollectibleNameInvalidException::class);

    CollectibleName::create("this is for sure a string longer than 50 characters");
  }
}