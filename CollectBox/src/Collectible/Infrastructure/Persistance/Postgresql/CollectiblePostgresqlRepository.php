<?php

declare(strict_types=1);

namespace App\Collectible\Infrastructure\Persistance\Postgresql;

use App\Collectible\Domain\Aggregate\Collectible;
use App\Collectible\Domain\Entity\CollectibleCode;
use App\Collectible\Domain\Entity\CollectibleCollection;
use App\Collectible\Domain\Entity\CollectibleId;
use App\Collectible\Domain\Entity\CollectibleName;
use App\Collectible\Domain\Entity\CollectibleUrl;
use App\Collectible\Domain\Exception\CollectibleNotFoundException;
use App\Collectible\Domain\Repository\CollectibleRepository;
use App\Shared\Domain\Entity\Collection;
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
            VALUES (:id, :code, :name, :url)"
    );
      
    $stmt->execute($this->fromObject($collectible));
    return $collectible;
  }

  //TODO: add criteria. Should be search
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

  public function findById(CollectibleId $id): Collectible 
  {
    $stmt = $this->pdo->prepare("SELECT * FROM collectible WHERE id = :id");
    $stmt->execute(["id" => $id->value()]);
    $collectible = $stmt->fetch(PDO::FETCH_OBJ);

    if (!$collectible) {
      throw CollectibleNotFoundException::create($id);
    }
    
    return $this->toObject($collectible);
  }

  private function toObject(object $collectible): Collectible
  {
    return Collectible::create(
      CollectibleId::create($collectible->id), 
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