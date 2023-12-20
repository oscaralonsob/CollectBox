<?php

declare(strict_types=1);

namespace App\Collectible\Application;

use App\Collectible\Domain\Exception\CollectibleNotFoundException;
use App\Collectible\Domain\Repository\CollectibleRepository;
use App\Shared\Domain\Entity\ValueObject\DomainId;

class DeleteCollectibleByIdCommandHandler
{ 
  public function __construct(private CollectibleRepository $collectibleRepository)
  {
  }

  public function execute(DeleteCollectibleByIdCommand $command): DomainId
  {
    $id = DomainId::create($command->id());
    $collectible = $this->collectibleRepository->findById($id);
    if (null == $collectible) {
      throw CollectibleNotFoundException::create($id);
    }

    $this->collectibleRepository->delete(DomainId::create($command->id()));

    return $id;
  }
}