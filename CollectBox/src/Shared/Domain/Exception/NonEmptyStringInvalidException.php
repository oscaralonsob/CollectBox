<?php

namespace App\Shared\Domain\Exception;

use Exception;

final class NonEmptyStringInvalidException extends Exception
{
  private const EXCEPTION_MESSAGE = "NonEmptyString is indeed empty";

  public static function create() {
    return new static(sprintf(static::EXCEPTION_MESSAGE));
  }
}
