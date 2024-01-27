<?php

namespace App\Collectible\Domain\Exception;

use Exception;

class CollectibleNameInvalidException extends Exception
{
  private const EXCEPTION_MESSAGE = "Collectible with invalid name: %s";

  public static function create(string $name): self {
    return new static(sprintf(static::EXCEPTION_MESSAGE, $name));
  }
}
