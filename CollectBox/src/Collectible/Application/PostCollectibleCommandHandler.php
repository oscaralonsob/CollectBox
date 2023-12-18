<?php

declare(strict_types=1);

namespace App\Collectible\Application;

use App\Collectible\Domain\Aggregate\Collectible;
use App\Collectible\Domain\Repository\CollectibleRepository;
use App\Collectible\Infrastructure\Persistance\InMemory\CollectibleInMemoryRepository;
use App\Shared\Domain\Entity\ValueObject\DomainId;

class PostCollectibleCommandHandler
{
  public function __construct(private CollectibleRepository $collectibleRepository)
  {
  }

  public function execute(PostCollectibleCommand $command): ?Collectible
  {
    $collectible = Collectible::create(
      DomainId::createRandom(),
      $command->name(),
      $command->rarity()
    );

    return $this->collectibleRepository->save($collectible);
  }
}