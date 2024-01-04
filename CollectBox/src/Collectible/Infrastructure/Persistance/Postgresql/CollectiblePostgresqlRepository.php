<?php

declare(strict_types=1);

namespace App\Collectible\Infrastructure\Persistance\Postgresql;

use App\Collectible\Domain\Aggregate\Collectible;
use App\Collectible\Domain\Entity\CollectibleCollection;
use App\Collectible\Domain\Repository\CollectibleRepository;
use App\Shared\Domain\Entity\Collection;
use App\Shared\Domain\Entity\ValueObject\DomainId;
use App\Shared\Domain\Entity\ValueObject\NonEmptyString;
use PDO;

//TODO: something like custom ORM to avoid code repetition
class CollectiblePostgresqlRepository implements CollectibleRepository
{
  public function __construct(private PDO $pdo)
  {
  }

  public function save(Collectible $collectible): ?Collectible 
  {
    $stmt = $this->pdo->prepare(
      "INSERT INTO collectible (id, name, rarity) 
            VALUES (:idValue, :nameValue, :rarityValue) 
            ON CONFLICT (id) DO UPDATE SET
            name = EXCLUDED.name,
            rarity = EXCLUDED.rarity"
    );
      
    $stmt->execute([
      "idValue" => $collectible->id()->value(),
      "nameValue" => $collectible->name()->value(),
      "rarityValue" => $collectible->rarity()->value(),
    ]);
    return $collectible;
  }

  public function delete(DomainId $collectibleId): DomainId 
  {
    $stmt = $this->pdo->prepare("DELETE FROM collectible WHERE id = :id");
    $stmt->execute(["id" => $collectibleId->value()]);
    return DomainId::create("ae8c868b-48cd-4457-9f2f-4c3f0d3d41a0");
  }

  public function findAll(): Collection
  {
    $stmt = $this->pdo->prepare("SELECT * FROM collectible");
    $stmt->execute();
    $collectibles = $stmt->fetchAll(PDO::FETCH_OBJ);

    $collection = CollectibleCollection::empty();
    foreach ($collectibles as $collectible) {
      $collection->add(
        Collectible::create(
          DomainId::create($collectible->id), 
          NonEmptyString::create($collectible->name), 
          NonEmptyString::create($collectible->rarity) 
        )
      );
    }
    
    return $collection;
  }

  public function findById(DomainId $id): ?Collectible 
  {
    $stmt = $this->pdo->prepare("SELECT * FROM collectible WHERE id = :id");
    $stmt->execute(["id" => $id->value()]);
    $collectible = $stmt->fetch(PDO::FETCH_OBJ);
    
    return $collectible ? Collectible::create(
      DomainId::create($collectible->id), 
      NonEmptyString::create($collectible->name), 
      NonEmptyString::create($collectible->rarity) 
    ) : null;
  }
}