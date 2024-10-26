<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Context\Collectible\Domain\Entity;

use App\Collectible\Domain\Entity\CollectibleId;
use Faker\Factory;

class CollectibleIdStub
{
  public static function random(): CollectibleId
  {
    $faker = Factory::create();
    
    return CollectibleId::create($faker->uuid);
  }
}