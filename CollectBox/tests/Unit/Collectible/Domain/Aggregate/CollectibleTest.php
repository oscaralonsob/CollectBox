<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Domain\Aggregate;

use App\Collectible\Domain\Aggregate\Collectible;
use Tests\Infrastructure\Collectible\Domain\Entity\CollectibleCodeStub;
use Tests\Infrastructure\Collectible\Domain\Entity\CollectibleIdStub;
use Tests\Infrastructure\Collectible\Domain\Entity\CollectibleNameStub;
use Tests\Infrastructure\Collectible\Domain\Entity\CollectibleUrlStub;
use Tests\Infrastructure\TestCase\BaseTestCase;

class CollectibleTest extends BaseTestCase
{
  public function testToArrayIsCorrect(): void
  {
    $collectibleId = CollectibleIdStub::random();
    $collectibleCode = CollectibleCodeStub::random();
    $collectibleName = CollectibleNameStub::random();
    $collectibleUrl = CollectibleUrlStub::random();

    $collectible = Collectible::create(
      $collectibleId,
      $collectibleCode,
      $collectibleName,
      $collectibleUrl
    );

    $this->assertEquals(
      [
        'id' => $collectibleId->value(),
        'code' => $collectibleCode->value(),
        'name' => $collectibleName->value(),
        'url' => $collectibleUrl->value(),
      ], 
      $collectible->toArray()
    );
  }
}