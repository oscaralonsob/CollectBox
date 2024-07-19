<?php

namespace App\User\Domain\Exception;

use Exception;

class PasswordInvalidException extends Exception
{
  private const EXCEPTION_MESSAGE = "Password is not valid";

  public static function create(string $name): self {
    return new static(sprintf(static::EXCEPTION_MESSAGE, $name));
  }
}
