<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Domain\Entity;

use App\Collectible\Domain\Entity\CollectibleCollection;
use App\Shared\Domain\Exception\CollectionInvalidTypeException;
use stdClass;
use Tests\Infrastructure\Context\Collectible\Domain\Aggregate\CollectibleStub;
use Tests\Infrastructure\TestCase\BaseTestCase;

class CollectibleCollectionTest extends BaseTestCase
{
  public function testCollectionCreation(): void
  {
    $testCollection = CollectibleCollection::create([CollectibleStub::random(), CollectibleStub::random()]);

    $this->assertCount(2, $testCollection->toArray());
  }

  public function testAddToCollection(): void
  {
    $testCollection = CollectibleCollection::create([CollectibleStub::random(),CollectibleStub::random()]);
    $testCollection->add(CollectibleStub::random());

    $this->assertCount(3, $testCollection->toArray());
  }

  public function testCollectionWrongCreation(): void
  {
    $this->expectException(CollectionInvalidTypeException::class);

    CollectibleCollection::create([new stdClass()]);
  }

  public function testAddToWrongCollection(): void
  {
    $this->expectException(CollectionInvalidTypeException::class);

    $testCollection = CollectibleCollection::create([CollectibleStub::random(), CollectibleStub::random()]);
    $testCollection->add(new stdClass());
  }
}