<?php

declare(strict_types=1);

namespace App\Application\Collectible;

class PutCollectibleCommand
{
  public function __construct(
    private string $id,
    private ?string $name,
    private ?string $rarity
  ) {}

  public function id(): string
  {
    return $this->id;
  }

  public function name(): ?string
  {
    return $this->name;
  }

  public function rarity(): ?string
  {
    return $this->rarity;
  }
}