<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Domain\Entity;

use App\Collectible\Domain\Aggregate\Collectible;
use App\Collectible\Domain\Entity\CollectibleCollection;
use App\Shared\Domain\Exception\CollectionInvalidTypeException;
use PHPUnit\Framework\TestCase;
use stdClass;

class CollectibleCollectionTest extends TestCase
{
  private Collectible $collectible1;
  private Collectible $collectible2;
  private Collectible $collectible3;

  public function setUp(): void
  {
    $this->collectible1 = Collectible::create(1, 'testName', 'testRarity');
    $this->collectible2 = Collectible::create(2, 'testName 2', 'testRarity 2');
    $this->collectible3 = Collectible::create(3, 'testName 3', 'testRarity 3');
  }

  public function testCollectionCreation(): void
  {
    $testCollection = CollectibleCollection::create([$this->collectible1, $this->collectible2]);

    $this->assertCount(2, $testCollection->toArray());
  }

  public function testAddToCollection(): void
  {
    $testCollection = CollectibleCollection::create([$this->collectible1, $this->collectible2]);
    $testCollection->add($this->collectible3);

    $this->assertCount(3, $testCollection->toArray());
  }

  public function testCollectionWrongCreation(): void
  {
    $this->expectException(CollectionInvalidTypeException::class);

    $testCollection = CollectibleCollection::create([new stdClass()]);
  }

  public function testAddToWrongCollection(): void
  {
    $this->expectException(CollectionInvalidTypeException::class);
    
    $testCollection = CollectibleCollection::create([$this->collectible1, $this->collectible2]);
    $testCollection->add(new stdClass());
  }
}