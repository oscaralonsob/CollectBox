<?php

declare(strict_types=1);


namespace Tests\Unit\Collectible\Infrastructure\Persistance\Postgresql;

use App\Collectible\Domain\Exception\CollectibleNotFoundException;
use App\Collectible\Infrastructure\Persistance\Postgresql\CollectiblePostgresqlRepository;
use Tests\BaseTestCase;
use Tests\Infrastructure\Collectible\Domain\Aggregate\CollectibleStub;

class CollectiblePostgresqlRepositoryTest extends BaseTestCase
{
  private CollectiblePostgresqlRepository $collectiblePostgresqlRepository;

  public function setUp(): void 
  {
    parent::setUp();
    //TODO: should be DI
    if (!isset($this->collectiblePostgresqlRepository)) {
      $this->collectiblePostgresqlRepository = new CollectiblePostgresqlRepository(self::$pdo);
    }
  }

  public function testSaveInsert(): void 
  {
    $collectible = CollectibleStub::random();

    $this->collectiblePostgresqlRepository->save($collectible);

    $this->assertSame($collectible->toArray(), $this->collectiblePostgresqlRepository->findById($collectible->id())->toArray());
  }

  public function testFindByIdWhenDoesExist(): void 
  {
    $collectible = CollectibleStub::fixture();
    $this->assertEquals($collectible->toArray(), $this->collectiblePostgresqlRepository->findById($collectible->id())->toArray());
  }

  public function testFindByIdWhenDoesNotExist(): void 
  {
    $collectible = CollectibleStub::random();
    $this->expectException(CollectibleNotFoundException::class);
    $this->collectiblePostgresqlRepository->findById($collectible->id());
  }

  public function testFindAll(): void 
  {
    $this->assertEquals(
      [CollectibleStub::fixture()],
      $this->collectiblePostgresqlRepository->findAll()->toArray()
    );
  }
} 