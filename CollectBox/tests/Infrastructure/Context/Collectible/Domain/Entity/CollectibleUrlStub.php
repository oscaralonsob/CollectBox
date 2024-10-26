<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Context\Collectible\Domain\Entity;

use App\Collectible\Domain\Entity\CollectibleUrl;
use Faker\Factory;

class CollectibleUrlStub
{
  public static function random(): CollectibleUrl
  {
    $faker = Factory::create();
    return CollectibleUrl::createFromRelative($faker->name);
  }
}