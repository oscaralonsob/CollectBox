<?php

declare(strict_types=1);

namespace App\Collectible\Domain\Repository;

use App\Collectible\Domain\Aggregate\Collectible;
use App\Shared\Domain\Entity\Collection;
use App\Shared\Domain\Entity\ValueObject\DomainId;

interface CollectibleRepository
{
  public function save(Collectible $collectible): Collectible ;

  public function delete(DomainId $collectibleId): DomainId;

  public function findAll(): Collection;

  public function findById(DomainId $id): ?Collectible;
} 