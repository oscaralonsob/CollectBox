<?php

declare(strict_types=1);

namespace App\Collectible\Domain\Entity;

use App\Collectible\Domain\Exception\CollectibleIdInvalidException;
use App\Shared\Domain\Entity\ValueObject\NonEmptyString;

class CollectibleId extends NonEmptyString
{
  private const VALIDATION_REGEX = "/B[0-9]{2}\-[0-9]{3}(N|HN|S?R\+?)/";

  private function __construct(string $value)
  {
    $this->guard($value);
    parent::__construct($value);
  }

  public static function create(string $value): self
  {
    return new self($value);
  }

  private function guard(string $value): void
  {
    if (!preg_match(self::VALIDATION_REGEX, $value)) {
      throw CollectibleIdInvalidException::create($value);
    }
  }
}