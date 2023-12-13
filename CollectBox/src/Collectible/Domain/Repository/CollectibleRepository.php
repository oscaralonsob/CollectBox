<?php

declare(strict_types=1);

namespace App\Collectible\Domain\Repository;

use App\Collectible\Domain\Aggregate\Collectible;

interface CollectibleRepository
{
  public function save(Collectible $collectible): ?Collectible ;

  public function delete(int $collectibleId): int; //TODO: change to uuid

  public function findAll(): array; //TODO: return collection

  public function findById(int $id): ?Collectible;
} 