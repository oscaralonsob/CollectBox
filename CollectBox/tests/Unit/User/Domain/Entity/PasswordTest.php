<?php

declare(strict_types=1);

namespace Tests\Unit\User\Domain\Entity;

use App\User\Domain\Entity\Password;
use App\User\Domain\Exception\PasswordInvalidException;
use Tests\Infrastructure\TestCase\BaseTestCase;

class PasswordTest extends BaseTestCase
{
  public function testCreate(): void
  {
    $password = Password::create("Password");

    $this->assertNotNull($password);
  }

  public function testCreateFromInvalid(): void
  {
    $this->expectException(PasswordInvalidException::class);

    Password::create("this is for sure a string longer than 50 characters");
  }
}