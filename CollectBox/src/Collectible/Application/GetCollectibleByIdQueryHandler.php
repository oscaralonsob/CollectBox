<?php

declare(strict_types=1);

namespace App\Collectible\Application;

use App\Collectible\Domain\Aggregate\Collectible;
use App\Collectible\Domain\Repository\CollectibleRepository;

class GetCollectibleByIdQueryHandler
{
  public function __construct(private CollectibleRepository $collectibleRepository)
  {
  }

  //TODO: return collectible
  public function execute(GetCollectibleByIdQuery $query): ?Collectible
  {
    return $this->collectibleRepository->findById($query->id());
  }
}