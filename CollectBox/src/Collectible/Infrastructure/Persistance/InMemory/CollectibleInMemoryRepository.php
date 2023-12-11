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

  public function save(Collectible $collectible): ?Collectible 
  {
    if ($collectible->id() == 0) {
      $newCollectibleId = max(array_keys($this->collectibles)) + 1;
      $collectible = Collectible::create(
        $newCollectibleId,
        $collectible->name(),
        $collectible->rarity()
      );
      $this->collectibles[$newCollectibleId] = $collectible;
  
      return $collectible;
    } 
    
    if (isset($this->collectibles[$collectible->id()])) {
      $this->collectibles[$collectible->id()] = $collectible;  
  
      return $collectible;  
    }

    return null;
  }

  public function delete(int $collectibleId): int 
  {
    if (isset($this->collectibles[$collectibleId])) {
      unset($this->collectibles[$collectibleId]);
    }
    return $collectibleId;
  }

  public function findAll(): array 
  {
    return $this->collectibles;
  }

  public function findById(int $id): ?Collectible 
  {
    return $this->collectibles[$id] ?? null;
  }
} 