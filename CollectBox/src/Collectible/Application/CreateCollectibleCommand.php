<?php

declare(strict_types=1);

namespace App\Collectible\Application;

class CreateCollectibleCommand
{
  private function __construct(
    private string $code,
    private string $name,
    private string $url
  ) {}

  public static function create(string $code, string $name, string $url): self
  {
    return new self($code, $name, $url);
  }

  public function code(): string
  {
    return $this->code;
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