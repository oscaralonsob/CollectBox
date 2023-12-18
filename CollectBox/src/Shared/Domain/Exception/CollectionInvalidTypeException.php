<?php

namespace App\Shared\Domain\Exception;

use Exception;

final class CollectionInvalidTypeException extends Exception
{
  private const EXCEPTION_MESSAGE = "Collection expect type %s, found type %s";

  public static function create(string $expectedType, string $actualType) {
    return new static(sprintf(static::EXCEPTION_MESSAGE, $expectedType, $actualType));
  }
}
