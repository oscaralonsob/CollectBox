<?php

declare(strict_types=1);

namespace App\Application\Collectible;

class GetCollectibleByIdQuery
{
  public function __construct(private int $id) {}

  public function id(): int
  {
    return $this->id;
  }
}