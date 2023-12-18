<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Domain\Aggregate;

use App\Collectible\Domain\Aggregate\Collectible;
use App\Shared\Domain\Entity\ValueObject\DomainId;
use App\Shared\Domain\Entity\ValueObject\NonEmptyString;
use PHPUnit\Framework\TestCase;

class CollectibleTest extends TestCase
{
  public function testToArrayIsCorrect(): void
  {
    $id = DomainId::createRandom();
    $name = NonEmptyString::create("TestName");
    $rarity = NonEmptyString::create("TestRarity");

    $collectible = Collectible::create(
      $id,
      $name,
      $rarity,
    );

    $this->assertEquals(
      [
        'id' => $id->value(),
        'name' => $name->value(),
        'rarity' => $rarity->value(),
      ], 
      $collectible->toArray()
    );
  }
}