<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Domain\Aggregate;

use App\Collectible\Domain\Aggregate\Collectible;
use App\Collectible\Domain\Entity\CollectibleCode;
use App\Collectible\Domain\Entity\CollectibleName;
use App\Collectible\Domain\Entity\CollectibleUrl;
use App\Shared\Domain\Entity\ValueObject\DomainId;

class CollectibleMother
{
  public static function create(): Collectible
  {
    return Collectible::create(
      DomainId::create("ae8c868b-48cd-4457-9f2f-4c3f0d3d41a0"),
      CollectibleCode::create("B01-001N"),
      CollectibleName::create("Collectible 1"),
      CollectibleUrl::create("https://wiki.serenesforest.net/index.php/Collectible-1")
    );
  }

  public static function createRandom(): Collectible
  {
    return Collectible::create(
      DomainId::createRandom(),
      CollectibleCode::create("B01-002HN"),
      CollectibleName::create("Test Name"),
      CollectibleUrl::create("https://wiki.serenesforest.net/index.php/Collectible-2")
    );
  }
}