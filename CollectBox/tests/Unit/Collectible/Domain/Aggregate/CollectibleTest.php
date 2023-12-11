<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Domain\Aggregate;

use App\Collectible\Domain\Aggregate\Collectible;
use PHPUnit\Framework\TestCase;

class CollectibleTest extends TestCase
{
  public function testToArrayIsCorrect(): void
  {
    $id = 1;
    $name = "TestName";
    $rarity = "TestRarity";

    $collectible = Collectible::create(
      $id,
      $name,
      $rarity,
    );

    $this->assertEquals(
      [
        'id' => $id,
        'name' => $name,
        'rarity' => $rarity,
      ], 
      $collectible->toArray()
    );
  }
}