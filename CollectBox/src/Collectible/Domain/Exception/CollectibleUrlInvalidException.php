<?php

namespace App\Collectible\Domain\Exception;

use Exception;

class CollectibleUrlInvalidException extends Exception
{
  private const EXCEPTION_MESSAGE = "Collectible with invalid url: %s";

  public static function create(string $url): self {
    return new static(sprintf(static::EXCEPTION_MESSAGE, $url));
  }
}
