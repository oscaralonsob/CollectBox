<?php

declare(strict_types=1);

namespace App\Collectible\Application;

use App\Collectible\Domain\Aggregate\Collectible;
use App\Collectible\Domain\Exception\CollectibleNotFoundException;
use App\Collectible\Domain\Repository\CollectibleRepository;
use App\Shared\Domain\Entity\ValueObject\DomainId;
use App\Shared\Domain\Entity\ValueObject\NonEmptyString;
use App\Shared\Domain\Exception\NonEmptyStringInvalidException;

class PutCollectibleCommandHandler
{
  public function __construct(private CollectibleRepository $collectibleRepository)
  {
  }

  public function execute(PutCollectibleCommand $command): ?Collectible
  {
    $id = DomainId::create($command->id());
    $name = NonEmptyString::create($command->name());
    $rarity = NonEmptyString::create($command->rarity());

    $collectible = $this->collectibleRepository->findById($id);
    if (null == $collectible) {
      throw CollectibleNotFoundException::create($id);
    }

    $collectible
      ->rename($name)
      ->changeRarity($rarity);

    return $this->collectibleRepository->save($collectible);
  }
}