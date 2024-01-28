<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Domain\Aggregate;

use App\Collectible\Domain\Aggregate\Collectible;
use App\Collectible\Domain\Entity\CollectibleName;
use App\Shared\Domain\Entity\ValueObject\DomainId;
use App\Shared\Domain\Entity\ValueObject\NonEmptyString;

class CollectibleMother
{
  public static function create(): Collectible
  {
    return Collectible::create(
      DomainId::create("ae8c868b-48cd-4457-9f2f-4c3f0d3d41a0"),
      CollectibleName::create("Collectible 1"),
      NonEmptyString::create("Common")
    );
  }

  public static function createRandom(): Collectible
  {
    return Collectible::create(
      DomainId::createRandom(),
      CollectibleName::create("Test Name"),
      NonEmptyString::create("Test Rarity")
    );
  }
}