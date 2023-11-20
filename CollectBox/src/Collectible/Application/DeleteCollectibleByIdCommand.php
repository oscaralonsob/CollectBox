<?php

declare(strict_types=1);

namespace App\Collectible\Application;

class DeleteCollectibleByIdCommand
{
  private function __construct(private int $id) {}

  public static function create(int $id): self
  {
    return new self($id);
  }

  public function id(): int
  {
    return $this->id;
  }
}