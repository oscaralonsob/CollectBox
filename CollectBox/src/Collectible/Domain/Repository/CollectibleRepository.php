<?php

declare(strict_types=1);

namespace App\Collectible\Domain\Repository;

use App\Collectible\Domain\Aggregate\Collectible;
use App\Collectible\Domain\Entity\CollectibleId;
use App\Shared\Domain\Entity\Collection;

interface CollectibleRepository
{
  public function save(Collectible $collectible): Collectible ;

  public function findAll(): Collection;

  public function findById(CollectibleId $id): Collectible;
} 