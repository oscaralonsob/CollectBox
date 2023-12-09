<?php

declare(strict_types=1);

namespace App\Collectible\Application;

use App\Collectible\Domain\Repository\CollectibleRepository;
use App\Collectible\Infrastructure\Persistance\InMemory\CollectibleInMemoryRepository;

class DeleteCollectibleByIdCommandHandler
{
  private const ID = "ID";
  
  private CollectibleRepository $collectibleRepository;

  public function __construct()
  {
    $this->collectibleRepository = new CollectibleInMemoryRepository(); //TODO: DI
  }

  public function execute(DeleteCollectibleByIdCommand $command): array
  {
    $this->collectibleRepository->delete($command->id());

    return [self::ID => $command->id()];
  }
}