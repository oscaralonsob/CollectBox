<?php

namespace App\User\Domain\Entity;

use App\Shared\Domain\Entity\TypedCollection;
use App\User\Domain\Aggregate\User;

class UserCollection extends TypedCollection
{
  protected function type(): string
  {
    return User::class;
  }
}
