<?php

declare(strict_types=1);

namespace Tests\Infrastructure\User\Domain\Entity;

use App\User\Domain\Entity\UserId;
use Faker\Factory;

class UserIdStub
{
  public static function random(): UserId
  {
    $faker = Factory::create();
    
    return UserId::create($faker->uuid);
  }
}