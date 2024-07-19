<?php

declare(strict_types=1);

namespace Tests\Unit\User\Domain\Aggregate;

use App\User\Domain\Aggregate\User;
use Tests\Infrastructure\TestCase\BaseTestCase;
use Tests\Infrastructure\User\Domain\Entity\PasswordStub;
use Tests\Infrastructure\User\Domain\Entity\UserIdStub;
use Tests\Infrastructure\User\Domain\Entity\UserNameStub;

class UserTest extends BaseTestCase
{
  public function testToArrayIsCorrect(): void
  {
    $userId = UserIdStub::random();
    $userName = UserNameStub::random();
    $password = PasswordStub::random();

    $user = User::create(
      $userId,
      $userName,
      $password
    );

    $this->assertEquals(
      [
        'id' => $userId->value(),
        'userName' => $userName->value(),
        'password' => $password->value(),
      ], 
      $user->toArray()
    );
  }
}