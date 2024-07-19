<?php

declare(strict_types=1);

namespace Tests\Infrastructure\User\Domain\Entity;

use App\User\Domain\Entity\Password;
use Faker\Factory;

class PasswordStub
{
  public static function random(): Password
  {
    $faker = Factory::create();
    return Password::create($faker->password);
  }
}