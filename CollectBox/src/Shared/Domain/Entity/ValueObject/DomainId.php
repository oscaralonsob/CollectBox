<?php

namespace App\Shared\Domain\Entity\ValueObject;

use App\Shared\Domain\Exception\UuidInvalidException;
use Ramsey\Uuid\Uuid;

class DomainId
{
  public function __construct(protected string $value)
  {
    $this->guard($value);
  }

  private function guard(string $value): void
  {
    if (!Uuid::isValid($value)) {
      throw UuidInvalidException::create($value);
    }
  }

  public static function create(string $uuid): static
  {
    return new static($uuid);
  }

  public static function createRandom(): static
  {
    return new static(Uuid::uuid4()->toString());
  }

  public function value(): string
  {
    return $this->value;
  }

  public function equalsTo(DomainId $other): bool
  {
    return $this->value == $other->value();
  }
}
