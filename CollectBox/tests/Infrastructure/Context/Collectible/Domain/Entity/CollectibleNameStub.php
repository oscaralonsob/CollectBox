<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Context\Collectible\Domain\Entity;

use App\Collectible\Domain\Entity\CollectibleName;
use Faker\Factory;

class CollectibleNameStub
{
  public static function random(): CollectibleName
  {
    $faker = Factory::create();
    return CollectibleName::create($faker->name);
  }
}