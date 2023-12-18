<?php

declare(strict_types=1);

namespace App\Collectible\Application;

class PutCollectibleCommand
{
  private function __construct(
    private string $id,
    private ?string $name,
    private ?string $rarity
  ) {}

  public static function create(string $id, ?string $name, ?string $rarity): self
  {
    return new self($id, $name, $rarity);
  }

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