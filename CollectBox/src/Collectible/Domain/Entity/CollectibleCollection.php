<?php

namespace App\Collectible\Domain\Entity;

use App\Collectible\Domain\Aggregate\Collectible;
use App\Shared\Domain\Entity\TypedCollection;

class CollectibleCollection extends TypedCollection
{
  protected function type(): string
  {
    return Collectible::class;
  }
}
