<?php

declare(strict_types=1);

namespace App\Collectible\Application;

use App\Collectible\Domain\Aggregate\Collectible;
use App\Collectible\Domain\Repository\CollectibleRepository;
use App\Shared\Domain\Entity\ValueObject\DomainId;

class GetCollectibleByIdQueryHandler
{
  public function __construct(private CollectibleRepository $collectibleRepository)
  {
  }

  public function execute(GetCollectibleByIdQuery $query): ?Collectible
  {
    return $this->collectibleRepository->findById(DomainId::create($query->id()));
  }
}