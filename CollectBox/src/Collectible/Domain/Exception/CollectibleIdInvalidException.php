<?php

namespace App\Collectible\Domain\Exception;

use Exception;

class CollectibleIdInvalidException extends Exception
{
  private const EXCEPTION_MESSAGE = "Collectible with invalid id: %s";

  public static function create(string $id): self {
    return new static(sprintf(static::EXCEPTION_MESSAGE, $id));
  }
}
