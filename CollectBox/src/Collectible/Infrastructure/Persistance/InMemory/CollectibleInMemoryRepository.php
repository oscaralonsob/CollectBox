<?php

declare(strict_types=1);

namespace App\Collectible\Infrastructure\Persistance\InMemory;

use App\Collectible\Domain\Aggregate\Collectible;
use App\Collectible\Domain\Entity\CollectibleCode;
use App\Collectible\Domain\Entity\CollectibleCollection;
use App\Collectible\Domain\Entity\CollectibleName;
use App\Collectible\Domain\Entity\CollectibleUrl;
use App\Collectible\Domain\Repository\CollectibleRepository;
use App\Shared\Domain\Entity\Collection;
use App\Shared\Domain\Entity\ValueObject\DomainId;

class CollectibleInMemoryRepository implements CollectibleRepository
{
  private array $collectibles = [];

  public function __construct()
  {
    $this->collectibles = [
      "ae8c868b-48cd-4457-9f2f-4c3f0d3d41a0" => Collectible::create(DomainId::create("ae8c868b-48cd-4457-9f2f-4c3f0d3d41a0"), CollectibleCode::create("B01-001N"), CollectibleName::create("Collectible 1"), CollectibleUrl::create("https://wiki.serenesforest.net/index.php/Collectible-1")),
      "7982e692-dd0b-49c6-a08c-0776b39e9e6c" => Collectible::create(DomainId::create("7982e692-dd0b-49c6-a08c-0776b39e9e6c"), CollectibleCode::create("B01-002N"), CollectibleName::create("Collectible 2"), CollectibleUrl::create("https://wiki.serenesforest.net/index.php/Collectible-2")),
    ];
  }

  public function save(Collectible $collectible): Collectible 
  {
    if (!isset($this->collectibles[$collectible->id()->value()])) {
      $collectible = Collectible::create(
        $collectible->id(),
        $collectible->code(),
        $collectible->name(),
        $collectible->url()
      );
      $this->collectibles[$collectible->id()->value()] = $collectible;
  
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

  public function findAll(): Collection
  {
    $collectibles = $this->collectibles;
    $collection = CollectibleCollection::empty();
    foreach ($collectibles as $collectible) {
      $collection->add($collectible);
    }
    
    return $collection;
  }

  public function findById(DomainId $id): ?Collectible 
  {
    return $this->collectibles[$id->value()] ?? null;
  }
} 