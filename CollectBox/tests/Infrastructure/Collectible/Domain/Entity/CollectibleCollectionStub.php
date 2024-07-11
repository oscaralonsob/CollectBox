<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Collectible\Domain\Entity;

use App\Collectible\Domain\Entity\CollectibleCollection;
use Tests\Infrastructure\Collectible\Domain\Aggregate\CollectibleStub;

class CollectibleCollectionStub
{
  public static function random(): CollectibleCollection
  {
    return CollectibleCollection::create([CollectibleStub::random(), CollectibleStub::random()]);
  }

  public static function empty(): CollectibleCollection
  {
    return CollectibleCollection::create([]);
  }
}