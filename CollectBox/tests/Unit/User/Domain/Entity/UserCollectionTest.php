<?php

declare(strict_types=1);

namespace Tests\Unit\User\Domain\Entity;

use App\Shared\Domain\Exception\CollectionInvalidTypeException;
use App\User\Domain\Entity\UserCollection;
use stdClass;
use Tests\Infrastructure\TestCase\BaseTestCase;
use Tests\Infrastructure\User\Domain\Aggregate\UserStub;

class UserCollectionTest extends BaseTestCase
{
  public function testCollectionCreation(): void
  {
    $testCollection = UserCollection::create([UserStub::random(), UserStub::random()]);

    $this->assertCount(2, $testCollection->toArray());
  }

  public function testAddToCollection(): void
  {
    $testCollection = UserCollection::create([UserStub::random(),UserStub::random()]);
    $testCollection->add(UserStub::random());

    $this->assertCount(3, $testCollection->toArray());
  }

  public function testCollectionWrongCreation(): void
  {
    $this->expectException(CollectionInvalidTypeException::class);

    UserCollection::create([new stdClass()]);
  }

  public function testAddToWrongCollection(): void
  {
    $this->expectException(CollectionInvalidTypeException::class);

    $testCollection = UserCollection::create([UserStub::random(), UserStub::random()]);
    $testCollection->add(new stdClass());
  }
}