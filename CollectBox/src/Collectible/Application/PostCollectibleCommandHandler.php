<?php

declare(strict_types=1);

namespace App\Collectible\Application;

use App\Collectible\Domain\Aggregate\Collectible;
use App\Collectible\Domain\Repository\CollectibleRepository;
use App\Collectible\Infrastructure\Persistance\InMemory\CollectibleInMemoryRepository;
use App\Shared\Domain\Entity\ValueObject\DomainId;
use App\Shared\Domain\Entity\ValueObject\NonEmptyString;

class PostCollectibleCommandHandler
{
  public function __construct(private CollectibleRepository $collectibleRepository)
  {
  }

  public function execute(PostCollectibleCommand $command): ?Collectible
  {
    $collectible = Collectible::create(
      DomainId::createRandom(),
      NonEmptyString::create($command->name()),
      NonEmptyString::create($command->rarity())
    );

    return $this->collectibleRepository->save($collectible);
  }
}