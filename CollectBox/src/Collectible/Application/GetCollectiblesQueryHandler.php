<?php

declare(strict_types=1);

namespace App\Collectible\Application;

use App\Collectible\Domain\Repository\CollectibleRepository;

class GetCollectiblesQueryHandler
{
  public function __construct(private CollectibleRepository $collectibleRepository)
  {
  }

  public function execute(GetCollectiblesQuery $query): array
  {
    return $this->collectibleRepository->findAll();
  }
}