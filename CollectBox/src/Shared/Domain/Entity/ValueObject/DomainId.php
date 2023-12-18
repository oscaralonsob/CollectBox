<?php

namespace App\Shared\Domain\Entity\ValueObject;

use App\Shared\Domain\Exception\UuidInvalidException;
use Ramsey\Uuid\Uuid;

class DomainId
{
  public function __construct(protected string $value)
  {
  }

  public static function create(string $uuid): self
  {
    if (!Uuid::isValid($uuid)) {
      throw UuidInvalidException::create($uuid);
    }

    return new self($uuid);
  }

  public static function createRandom(): self
  {
    return new self(Uuid::uuid4()->toString());
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
