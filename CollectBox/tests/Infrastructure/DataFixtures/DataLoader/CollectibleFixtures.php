<?php

declare(strict_types=1);

namespace Tests\Infrastructure\DataFixtures\DataLoader;

use App\Collectible\Domain\Aggregate\Collectible;
use App\Collectible\Domain\Entity\CollectibleCode;
use App\Collectible\Domain\Entity\CollectibleId;
use App\Collectible\Domain\Entity\CollectibleName;
use App\Collectible\Domain\Entity\CollectibleUrl;
use PDO;
use Symfony\Component\Yaml\Yaml;

class CollectibleFixtures
{
  //TODO: DI
  public function load(PDO $pdo): void
  {
    foreach (Yaml::parseFile('tests/Infrastructure/DataFixtures/Fixtures/collectibles.yaml')['collectible'] as $collectibleFixture) {
      $collectible = Collectible::create(
        CollectibleId::create($collectibleFixture['id']),
        CollectibleCode::create($collectibleFixture['code']),
        CollectibleName::create($collectibleFixture['name']),
        CollectibleUrl::create($collectibleFixture['url'])
      );

      $stmt = $pdo->prepare(
        "INSERT INTO collectible (id, code, name, url) 
              VALUES (:id, :code, :name, :url)"
      );
        
      $stmt->execute([
        "id" => $collectible->id()->value(),
        "code" => $collectible->code()->value(),
        "name" => $collectible->name()->value(),
        "url" => $collectible->url()->value(),
      ]);
    }
  }
}