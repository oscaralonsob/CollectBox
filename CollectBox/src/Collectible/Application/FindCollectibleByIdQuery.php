<?php

declare(strict_types=1);

namespace App\Collectible\Application;

class FindCollectibleByIdQuery
{
  private function __construct(private string $id) {}

  public static function create(string $id): self
  {
    return new self($id);
  }

  public function id(): string
  {
    return $this->id;
  }
}