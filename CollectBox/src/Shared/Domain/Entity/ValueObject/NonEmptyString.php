<?php

namespace App\Shared\Domain\Entity\ValueObject;

use App\Shared\Domain\Exception\NonEmptyStringInvalidException;

class NonEmptyString
{
  public function __construct(protected string $value)
  {
  }

  public static function create(string $value): self
  {
    if ("" == $value) {
      throw NonEmptyStringInvalidException::create();
    }

    return new self($value);
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
