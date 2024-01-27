<?php

declare(strict_types=1);

namespace App\Collectible\Domain\Entity;

use App\Collectible\Domain\Exception\CollectibleNameInvalidException;
use App\Shared\Domain\Entity\ValueObject\NonEmptyString;

class CollectibleName extends NonEmptyString
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

  private function guard(string $value): void
  {
    if (strlen($value) > 50) {
      throw CollectibleNameInvalidException::create($value);
    }
  }
}