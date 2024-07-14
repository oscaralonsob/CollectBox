<?php

declare(strict_types=1);

namespace App\Collectible\Application;

use App\Collectible\Domain\Aggregate\Collectible;
use App\Collectible\Domain\Entity\CollectibleId;
use App\Collectible\Domain\Repository\CollectibleRepository;

class FindCollectibleByIdQueryHandler
{
  public function __construct(private CollectibleRepository $collectibleRepository)
  {
  }

  public function execute(FindCollectibleByIdQuery $query): ?Collectible
  {
    return $this->collectibleRepository->findById(CollectibleId::create($query->id()));
  }
}