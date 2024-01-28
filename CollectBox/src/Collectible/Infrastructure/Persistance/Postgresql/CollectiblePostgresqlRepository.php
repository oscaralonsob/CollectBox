<?php

declare(strict_types=1);

namespace App\Collectible\Infrastructure\Persistance\Postgresql;

use App\Collectible\Domain\Aggregate\Collectible;
use App\Collectible\Domain\Entity\CollectibleCode;
use App\Collectible\Domain\Entity\CollectibleCollection;
use App\Collectible\Domain\Entity\CollectibleName;
use App\Collectible\Domain\Entity\CollectibleUrl;
use App\Collectible\Domain\Repository\CollectibleRepository;
use App\Shared\Domain\Entity\Collection;
use App\Shared\Domain\Entity\ValueObject\DomainId;
use PDO;

class CollectiblePostgresqlRepository implements CollectibleRepository
{
  public function __construct(private PDO $pdo)
  {
  }

  public function save(Collectible $collectible): Collectible 
  {
    $stmt = $this->pdo->prepare(
      "INSERT INTO collectible (id, code, name, url) 
            VALUES (:id, :code, :name, :url) 
            ON CONFLICT (id) DO UPDATE SET
            code = EXCLUDED.code,
            name = EXCLUDED.name,
            url = EXCLUDED.url"
    );
      
    $stmt->execute($this->fromObject($collectible));
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
        $this->toObject($collectible)
      );
    }
    
    return $collection;
  }

  public function findById(DomainId $id): ?Collectible 
  {
    $stmt = $this->pdo->prepare("SELECT * FROM collectible WHERE id = :id");
    $stmt->execute(["id" => $id->value()]);
    $collectible = $stmt->fetch(PDO::FETCH_OBJ);
    
    return $collectible ? $this->toObject($collectible) : null;
  }

  private function toObject(object $collectible): Collectible
  {
    return Collectible::create(
      DomainId::create($collectible->id), 
      CollectibleCode::create($collectible->code), 
      CollectibleName::create($collectible->name), 
      CollectibleUrl::create($collectible->url) 
    );
  }

  private function fromObject(Collectible $collectible): array
  {
    return [
      "id" => $collectible->id()->value(),
      "code" => $collectible->code()->value(),
      "name" => $collectible->name()->value(),
      "url" => $collectible->url()->value(),
    ];
  }
}