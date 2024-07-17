<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Domain\Entity;

use App\Shared\Domain\Entity\Collection;
use Tests\Infrastructure\TestCase\BaseTestCase;

class CollectionTest extends BaseTestCase
{
  public function testEmptyCollectionCreation(): void
  {
    $testCollection = Collection::empty();

    $this->assertEmpty($testCollection->toArray());
  }

  public function testCollectionCreation(): void
  {
    $testCollection = Collection::create(['string 1', 'string 2']);

    $this->assertCount(2, $testCollection->toArray());
  }

  public function testCount(): void
  {
    $testCollection = Collection::create(['string 1', 'string 2', 'string 3']);

    $this->assertEquals(3, $testCollection->count());
  }

  public function testAddToCollection(): void
  {
    $testCollection = Collection::create(['string 1', 'string 2']);
    $testCollection->add('string 3');

    $this->assertCount(3, $testCollection->toArray());
  }

  public function testGetIterator(): void
  {
    $testCollection = Collection::create(['string 1', 'string 2']);

    $array = [];
    foreach ($testCollection->getIterator() as $element) {
      $array[] = $element;
    }

    $this->assertEquals($testCollection->toArray(), $array);
  }
}