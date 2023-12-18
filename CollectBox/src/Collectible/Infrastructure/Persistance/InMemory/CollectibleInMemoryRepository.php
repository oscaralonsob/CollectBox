<?php

declare(strict_types=1);

namespace App\Collectible\Infrastructure\Persistance\InMemory;

use App\Collectible\Domain\Aggregate\Collectible;
use App\Collectible\Domain\Repository\CollectibleRepository;
use App\Shared\Domain\Entity\ValueObject\DomainId;

class CollectibleInMemoryRepository implements CollectibleRepository
{
  private array $collectibles = [];

  public function __construct()
  {
    $this->collectibles = [
      "ae8c868b-48cd-4457-9f2f-4c3f0d3d41a0" => Collectible::create(DomainId::create("ae8c868b-48cd-4457-9f2f-4c3f0d3d41a0"), "Collectible 1", "Common"),
      "7982e692-dd0b-49c6-a08c-0776b39e9e6c" => Collectible::create(DomainId::create("7982e692-dd0b-49c6-a08c-0776b39e9e6c"), "Collectible 2", "Rare"),
    ];
  }

  public function save(Collectible $collectible): ?Collectible 
  {
    if (!isset($this->collectibles[$collectible->id()->value()])) {
      $newCollectibleId = DomainId::createRandom();
      $collectible = Collectible::create(
        $newCollectibleId,
        $collectible->name(),
        $collectible->rarity()
      );
      $this->collectibles[$newCollectibleId->value()] = $collectible;
  
      return $collectible;
    }else {
      $this->collectibles[$collectible->id()->value()] = $collectible;  
  
      return $collectible;  
    }
  }

  public function delete(DomainId $collectibleId): DomainId 
  {
    if (isset($this->collectibles[$collectibleId->value()])) {
      unset($this->collectibles[$collectibleId->value()]);
    }
    return $collectibleId;
  }

  public function findAll(): array 
  {
    return $this->collectibles;
  }

  public function findById(DomainId $id): ?Collectible 
  {
    return $this->collectibles[$id->value()] ?? null;
  }
} 