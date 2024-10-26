<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Context\Collectible\Domain\Entity;

use App\Collectible\Domain\Entity\CollectibleCode;
use Faker\Factory;

class CollectibleCodeStub
{
  private const VALIDATION_REGEX = "/B[0-9]{2}\-[0-9]{3}(N|HN|X|S?R\+?)/";

  public static function random(): CollectibleCode
  {
    $faker = Factory::create();

    return CollectibleCode::create($faker->regexify(self::VALIDATION_REGEX)); 
  }
}