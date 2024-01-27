<?php

namespace App\Shared\Domain\Entity\ValueObject;

use App\Shared\Domain\Exception\NonEmptyStringInvalidException;

class NonEmptyString
{
  public function __construct(protected string $value)
  {
    $this->guard($value);
  }

  public static function create(string $value): self
  {
    return new self($value);
  }

  private function guard(string $value): void
  {
    if ("" == $value) {
      throw NonEmptyStringInvalidException::create();
    }
  }

  public function value(): string
  {
    return $this->value;
  }

  public function equalsTo(NonEmptyString $other): bool
  {
    return $this->value == $other->value();
  }
}
