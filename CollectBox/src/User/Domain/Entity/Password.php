<?php

declare(strict_types=1);

namespace App\User\Domain\Entity;

use App\Shared\Domain\Entity\ValueObject\NonEmptyString;
use App\User\Domain\Exception\PasswordInvalidException;

class Password extends NonEmptyString
{
  
  private function __construct(string $value)
  {
    $this->guard($value);
    parent::__construct($value);
  }

  public static function create(string $value): self
  {
    return new self($value);
  }

  //TODO: do checks
  private function guard(string $value): void
  {
    if (strlen($value) > 50) {
      throw PasswordInvalidException::create($value);
    }
  }
}