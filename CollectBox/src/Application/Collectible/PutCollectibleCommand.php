<?php

declare(strict_types=1);

namespace App\Application\Collectible;

class PutCollectibleCommand
{
  private function __construct(
    private int $id,
    private ?string $name,
    private ?string $rarity
  ) {}

  public static function create(int $id, ?string $name, ?string $rarity): self
  {
    return new self($id, $name, $rarity);
  }

  public function id(): int
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