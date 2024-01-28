<?php

namespace App\Collectible\Domain\Exception;

use Exception;

class CollectibleCodeInvalidException extends Exception
{
  private const EXCEPTION_MESSAGE = "Collectible with invalid code: %s";

  public static function create(string $code): self {
    return new static(sprintf(static::EXCEPTION_MESSAGE, $code));
  }
}
