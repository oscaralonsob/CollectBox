<?php

declare(strict_types=1);

namespace App\Collectible\Application;

use App\Collectible\Domain\Repository\CollectibleRepository;
use App\Shared\Domain\Entity\Collection;

class GetCollectiblesQueryHandler
{
  public function __construct(private CollectibleRepository $collectibleRepository)
  {
  }

  public function execute(GetCollectiblesQuery $query): Collection
  {
    return $this->collectibleRepository->findAll();
  }
}