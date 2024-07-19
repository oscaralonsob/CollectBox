<?php

declare(strict_types=1);

namespace Tests\Infrastructure\User\Domain\Entity;

use App\User\Domain\Entity\UserName;
use Faker\Factory;

class UserNameStub
{
  public static function random(): UserName
  {
    $faker = Factory::create();
    return UserName::create($faker->name);
  }
}