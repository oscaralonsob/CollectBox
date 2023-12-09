<?php

declare(strict_types=1);

namespace App\Collectible\Application;

use App\Collectible\Domain\Aggregate\Collectible;
use App\Collectible\Domain\Repository\CollectibleRepository;
use App\Collectible\Infrastructure\Persistance\InMemory\CollectibleInMemoryRepository;

class PutCollectibleCommandHandler
{
  public function __construct(private CollectibleRepository $collectibleRepository)
  {
  }

  public function execute(PutCollectibleCommand $command): ?Collectible
  {
    $collectible = Collectible::create(
      $command->id(),
      $command->name(),
      $command->rarity()
    );

    return $this->collectibleRepository->save($collectible);
  }
}