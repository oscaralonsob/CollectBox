<?php

declare(strict_types=1);

namespace App\Collectible\Application;

use App\Collectible\Domain\Repository\CollectibleRepository;
use App\Collectible\Infrastructure\Persistance\InMemory\CollectibleInMemoryRepository;

class DeleteCollectibleByIdCommandHandler
{ 
  public function __construct(private CollectibleRepository $collectibleRepository)
  {
  }

  public function execute(DeleteCollectibleByIdCommand $command): int
  {
    $this->collectibleRepository->delete($command->id());

    return $command->id();
  }
}