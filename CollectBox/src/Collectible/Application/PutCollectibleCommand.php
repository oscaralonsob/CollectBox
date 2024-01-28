<?php

declare(strict_types=1);

namespace App\Collectible\Application;

class PutCollectibleCommand
{
  private function __construct(
    private string $id,
    private ?string $name,
    private ?string $url
  ) {}

  public static function create(string $id, ?string $name, ?string $url): self
  {
    return new self($id, $name, $url);
  }

  public function id(): string
  {
    return $this->id;
  }

  public function name(): ?string
  {
    return $this->name;
  }

  public function url(): ?string
  {
    return $this->url;
  }
}