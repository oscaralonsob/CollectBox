<?php

declare(strict_types=1);

namespace App\User\Application;

class LoginCommand
{
  private function __construct(
    private string $userName,
    private string $password
  ) {}

  public static function create(string $userName, string $password): self
  {
    return new self($userName, $password);
  }

  public function userName(): string
  {
    return $this->userName;
  }

  public function password(): string
  {
    return $this->password;
  }
}