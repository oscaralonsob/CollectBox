<?php

namespace App\Application\Collectible;

class PostCollectibleCommand
{
  public function __construct(
    private string $name,
    private string $rarity
  ) {}

  public function name(): string
  {
    return $this->name;
  }

  public function rarity(): string
  {
    return $this->rarity;
  }
}