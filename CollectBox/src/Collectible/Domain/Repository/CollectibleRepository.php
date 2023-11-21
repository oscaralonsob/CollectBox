<?php

declare(strict_types=1);

namespace App\Collectible\Domain\Repository;

use App\Collectible\Domain\Aggregate\Collectible;

interface CollectibleRepository
{
  public function findById(int $id): ?Collectible;
} 