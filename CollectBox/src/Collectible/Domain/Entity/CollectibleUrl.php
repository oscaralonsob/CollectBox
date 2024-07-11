<?php

declare(strict_types=1);

namespace App\Collectible\Domain\Entity;

use App\Collectible\Domain\Exception\CollectibleUrlInvalidException;
use App\Shared\Domain\Entity\ValueObject\NonEmptyString;

class CollectibleUrl extends NonEmptyString
{
  private const URL = "https://wiki.serenesforest.net/index.php/";

  private function __construct(string $value)
  {
    $this->guard($value);
    parent::__construct($value);
  }

  public static function create(string $value): self
  {
    return new self($value);
  }

  public static function createFromRelative(string $value): self
  {
    return new self(self::URL . $value);
  }

  private function guard(string $value): void
  {
    if (!str_starts_with($value, self::URL)) {
      throw CollectibleUrlInvalidException::create($value);
    }
  }
}