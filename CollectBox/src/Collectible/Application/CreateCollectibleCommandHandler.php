<?php

declare(strict_types=1);

namespace App\Collectible\Application;

use App\Collectible\Domain\Aggregate\Collectible;
use App\Collectible\Domain\Entity\CollectibleCode;
use App\Collectible\Domain\Entity\CollectibleId;
use App\Collectible\Domain\Entity\CollectibleName;
use App\Collectible\Domain\Entity\CollectibleUrl;
use App\Collectible\Domain\Repository\CollectibleRepository;

class CreateCollectibleCommandHandler
{
  public function __construct(private CollectibleRepository $collectibleRepository)
  {
  }

  public function execute(CreateCollectibleCommand $command): ?Collectible
  {
    $collectible = Collectible::create(
      CollectibleId::createRandom(),
      CollectibleCode::create($command->code()),
      CollectibleName::create($command->name()),
      CollectibleUrl::create($command->url())
    );

    return $this->collectibleRepository->save($collectible);
  }
}