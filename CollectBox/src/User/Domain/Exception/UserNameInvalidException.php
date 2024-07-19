<?php

namespace App\User\Domain\Exception;

use Exception;

class UserNameInvalidException extends Exception
{
  private const EXCEPTION_MESSAGE = "UserName <%s> is not valid";

  public static function create(string $name): self {
    return new static(sprintf(static::EXCEPTION_MESSAGE, $name));
  }
}
