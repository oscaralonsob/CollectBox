<?php

declare(strict_types=1);

namespace App\Collectible\Application;

class PostCollectibleCommand
{
  private function __construct(
    private string $name,
    private string $rarity
  ) {}

  public static function create(string $name, string $rarity): self
  {
    return new self($name, $rarity);
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