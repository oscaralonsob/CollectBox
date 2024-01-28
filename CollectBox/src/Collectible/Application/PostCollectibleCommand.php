<?php

declare(strict_types=1);

namespace App\Collectible\Application;

class PostCollectibleCommand
{
  private function __construct(
    private string $name,
    private string $url
  ) {}

  public static function create(string $name, string $url): self
  {
    return new self($name, $url);
  }

  public function name(): string
  {
    return $this->name;
  }

  public function url(): string
  {
    return $this->url;
  }
}