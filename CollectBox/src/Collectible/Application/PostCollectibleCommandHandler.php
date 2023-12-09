<?php

declare(strict_types=1);

namespace App\Collectible\Application;

use App\Collectible\Domain\Aggregate\Collectible;
use App\Collectible\Domain\Repository\CollectibleRepository;
use App\Collectible\Infrastructure\Persistance\InMemory\CollectibleInMemoryRepository;

class PostCollectibleCommandHandler
{
  private CollectibleRepository $collectibleRepository;

  public function __construct()
  {
    $this->collectibleRepository = new CollectibleInMemoryRepository(); //TODO: DI
  }

  public function execute(PostCollectibleCommand $command): ?Collectible
  {
    $collectible = Collectible::create(
      0, //this should be migrated to uuid
      $command->name(),
      $command->rarity()
    );

    return $this->collectibleRepository->save($collectible);
  }
}