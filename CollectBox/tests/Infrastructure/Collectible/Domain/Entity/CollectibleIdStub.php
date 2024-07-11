<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Collectible\Domain\Entity;

//TODO: move to shared
use App\Shared\Domain\Entity\ValueObject\DomainId;
use Faker\Factory;

class CollectibleIdStub
{
  public static function random(): DomainId
  {
    $faker = Factory::create();
    
    return DomainId::create($faker->uuid);
  }
}