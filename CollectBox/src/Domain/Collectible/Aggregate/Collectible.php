<?php

declare(strict_types=1);

namespace App\Domain\Collectible\Aggregate\Root;

class Collectible 
{
  public function __construct(
    private int $id,
    private string $name,
    private string $rarity
  ) {
  }

  public function id(): int
  {
    return $this->id;
  }

  public function name(): string
  {
    return $this->name;
  }

  public function rarity(): string
  {
    return $this->rarity;
  }
}