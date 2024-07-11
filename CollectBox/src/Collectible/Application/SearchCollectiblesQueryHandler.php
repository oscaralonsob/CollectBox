<?php

declare(strict_types=1);

namespace App\Collectible\Application;

use App\Collectible\Domain\Repository\CollectibleRepository;
use App\Shared\Domain\Entity\Collection;

class SearchCollectiblesQueryHandler
{
  public function __construct(private CollectibleRepository $collectibleRepository)
  {
  }

  public function execute(SearchCollectiblesQuery $query): Collection
  {
    return $this->collectibleRepository->findAll();
  }
}