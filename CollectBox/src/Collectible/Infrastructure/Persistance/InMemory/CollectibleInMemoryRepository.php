<?php

declare(strict_types=1);

namespace App\Collectible\Infrastructure\Persistance\InMemory;

use App\Collectible\Domain\Aggregate\Collectible;
use App\Collectible\Domain\Repository\CollectibleRepository;

class CollectibleInMemoryRepository implements CollectibleRepository
{
  private array $collectibles = [];

  public function __construct()
  {
    $this->collectibles = [
      1 => Collectible::create(1, "Collectible 1", "Common"),
      2 => Collectible::create(2, "Collectible 2", "Rare"),
    ];
  }

  public function findById(int $id): ?Collectible 
  {
    return $this->collectibles[$id] ?? null;
  }
} 