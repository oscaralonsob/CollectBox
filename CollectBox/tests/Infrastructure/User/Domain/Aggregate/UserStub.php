<?php

declare(strict_types=1);

namespace Tests\Infrastructure\User\Domain\Aggregate;

use App\User\Domain\Aggregate\User;
use App\User\Domain\Entity\Password;
use App\User\Domain\Entity\UserId;
use App\User\Domain\Entity\UserName;
use Tests\Infrastructure\User\Domain\Entity\PasswordStub;
use Tests\Infrastructure\User\Domain\Entity\UserIdStub;
use Tests\Infrastructure\User\Domain\Entity\UserNameStub;

class UserStub
{
  public static function random(
    ?UserId $id = null,
    ?UserName $userName = null,
    ?Password $password = null
  ): User {
    return User::create(
      $id ?? UserIdStub::random(), 
      $userName ?? UserNameStub::random(), 
      $password ?? PasswordStub::random()
    );
  }

  public static function fixture(): User {
    return User::create(
      UserId::create("baca94a4-a209-45e1-be33-d079248122ee"),  
      UserName::create("user"), 
      Password::create("password")
    );
  }
}