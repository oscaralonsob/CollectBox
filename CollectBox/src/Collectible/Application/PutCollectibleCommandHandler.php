<?php

declare(strict_types=1);

namespace App\Collectible\Application;

use App\Collectible\Domain\Aggregate\Collectible;
use App\Collectible\Domain\Entity\CollectibleName;
use App\Collectible\Domain\Entity\CollectibleUrl;
use App\Collectible\Domain\Exception\CollectibleNotFoundException;
use App\Collectible\Domain\Repository\CollectibleRepository;
use App\Shared\Domain\Entity\ValueObject\DomainId;

class PutCollectibleCommandHandler
{
  public function __construct(private CollectibleRepository $collectibleRepository)
  {
  }

  public function execute(PutCollectibleCommand $command): ?Collectible
  {
    $id = DomainId::create($command->id());
    $name = CollectibleName::create($command->name());
    $url = CollectibleUrl::create($command->url());

    $collectible = $this->collectibleRepository->findById($id);
    if (null == $collectible) {
      throw CollectibleNotFoundException::create($id);
    }

    $collectible
      ->rename($name)
      ->changeUrl($url);

    return $this->collectibleRepository->save($collectible);
  }
}