<?php

declare(strict_types=1);

namespace App\Collectible\Application;

use App\Collectible\Domain\Repository\CollectibleRepository;
use App\Collectible\Infrastructure\Persistance\InMemory\CollectibleInMemoryRepository;

class GetCollectibleByIdQueryHandler
{
  public function __construct(private CollectibleRepository $collectibleRepository)
  {
  }

  public function execute(GetCollectibleByIdQuery $query): array
  {
    return $this->collectibleRepository->findById($query->id())?->toArray() ?? [];
  }
}