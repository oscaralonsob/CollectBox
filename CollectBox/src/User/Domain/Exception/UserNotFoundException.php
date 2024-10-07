<?php

namespace App\User\Domain\Exception;

use App\User\Domain\Entity\UserId;
use Exception;

final class UserNotFoundException extends Exception
{
  private const EXCEPTION_MESSAGE = "User with Uuid  %s was not found";

  public static function create(UserId $id) {
    return new static(sprintf(static::EXCEPTION_MESSAGE, $id->value()));
  }
}
