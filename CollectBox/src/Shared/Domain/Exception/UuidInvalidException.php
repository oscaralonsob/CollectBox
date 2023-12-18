<?php

namespace App\Shared\Domain\Exception;

use Exception;

final class UuidInvalidException extends Exception
{
  private const EXCEPTION_MESSAGE = "Uuid invalid %s";

  public static function create(string $value) {
    return new static(sprintf(static::EXCEPTION_MESSAGE, $value));
  }
}
