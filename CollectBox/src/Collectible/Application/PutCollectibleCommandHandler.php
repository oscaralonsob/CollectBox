<?php

declare(strict_types=1);

namespace App\Collectible\Application;

use App\Collectible\Domain\Aggregate\Collectible;
use App\Collectible\Domain\Repository\CollectibleRepository;
use App\Shared\Domain\Entity\ValueObject\DomainId;
use App\Shared\Domain\Entity\ValueObject\NonEmptyString;

class PutCollectibleCommandHandler
{
  public function __construct(private CollectibleRepository $collectibleRepository)
  {
  }

  public function execute(PutCollectibleCommand $command): ?Collectible
  {
    //TODO: check if exists
    $collectible = Collectible::create(
      DomainId::create($command->id()),
      NonEmptyString::create($command->name()),
      NonEmptyString::create($command->rarity())
    );

    return $this->collectibleRepository->save($collectible);
  }
}