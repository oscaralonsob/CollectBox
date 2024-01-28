<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Domain\Aggregate;

use PHPUnit\Framework\TestCase;

class CollectibleTest extends TestCase
{
  public function testToArrayIsCorrect(): void
  {
    $collectible = CollectibleMother::create();

    $this->assertEquals(
      [
        'id' => "ae8c868b-48cd-4457-9f2f-4c3f0d3d41a0",
        'code' => "B01-001N",
        'name' => "Collectible 1",
        'url' => "https://wiki.serenesforest.net/index.php/Collectible-1",
      ], 
      $collectible->toArray()
    );
  }
}