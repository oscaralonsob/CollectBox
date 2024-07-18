<?php

declare(strict_types=1);


namespace Tests\Unit\Collectible\Infrastructure\Persistance\Postgresql;

use App\Collectible\Domain\Exception\CollectibleNotFoundException;
use App\Collectible\Infrastructure\Persistance\Postgresql\CollectiblePostgresqlRepository;
use Tests\Infrastructure\Collectible\Domain\Aggregate\CollectibleStub;
use Tests\Infrastructure\DataFixtures\DataLoader\CollectibleFixtures;
use Tests\Infrastructure\TestCase\RepositoryTestCase;

class CollectiblePostgresqlRepositoryTest extends RepositoryTestCase
{
  protected function setUp(): void
  {
    $this->fixtureLoader()->addFixtures(new CollectibleFixtures());
    parent::setUp();
  }

  public function testSaveInsert(): void 
  {
    $collectible = CollectibleStub::random();

    $this->repository()->save($collectible);

    $this->assertSame($collectible->toArray(), $this->repository()->findById($collectible->id())->toArray());
  }

  public function testFindByIdWhenDoesExist(): void 
  {
    $collectible = CollectibleStub::fixture();
    $this->assertEquals($collectible->toArray(), $this->repository()->findById($collectible->id())->toArray());
  }

  public function testFindByIdWhenDoesNotExist(): void 
  {
    $collectible = CollectibleStub::random();
    $this->expectException(CollectibleNotFoundException::class);
    $this->repository()->findById($collectible->id());
  }

  public function testFindAll(): void 
  {
    $this->assertCount(4, $this->repository()->findAll()->toArray());
  }

  public function repositoryClassName(): string
  {
    return CollectiblePostgresqlRepository::class;
  }
} 