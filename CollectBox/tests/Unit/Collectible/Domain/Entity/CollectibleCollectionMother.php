<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Domain\Entity;

use App\Collectible\Domain\Entity\CollectibleCollection;
use Tests\Unit\Collectible\Domain\Aggregate\CollectibleMother;

class CollectibleCollectionMother
{
  public static function create(): CollectibleCollection
  {
    return CollectibleCollection::create([
      CollectibleMother::createRandom(),
      CollectibleMother::createRandom(),
    ]);
  }

  public static function createEmpty(): CollectibleCollection
  {
    return CollectibleCollection::create([]);
  }
}