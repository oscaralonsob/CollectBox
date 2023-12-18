<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Domain\Entity;

use App\Collectible\Domain\Aggregate\Collectible;
use App\Collectible\Domain\Entity\CollectibleCollection;
use App\Shared\Domain\Entity\ValueObject\DomainId;
use App\Shared\Domain\Entity\ValueObject\NonEmptyString;
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
    $this->collectible1 = Collectible::create(DomainId::createRandom(), NonEmptyString::create('testName'), NonEmptyString::create('testRarity'));
    $this->collectible2 = Collectible::create(DomainId::createRandom(), NonEmptyString::create('testName 2'), NonEmptyString::create('testRarity 2'));
    $this->collectible3 = Collectible::create(DomainId::createRandom(), NonEmptyString::create('testName 3'), NonEmptyString::create('testRarity 3'));
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