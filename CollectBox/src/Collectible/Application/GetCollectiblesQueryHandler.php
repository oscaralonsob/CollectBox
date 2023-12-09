<?php

declare(strict_types=1);

namespace App\Collectible\Application;

use App\Collectible\Domain\Repository\CollectibleRepository;
use App\Collectible\Infrastructure\Persistance\InMemory\CollectibleInMemoryRepository;

class GetCollectiblesQueryHandler
{
  private CollectibleRepository $collectibleRepository;

  public function __construct()
  {
    $this->collectibleRepository = new CollectibleInMemoryRepository(); //TODO: DI
  }

  public function execute(GetCollectiblesQuery $query): array
  {
    return $this->collectibleRepository->findAll();
  }
}