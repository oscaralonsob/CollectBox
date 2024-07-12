<?php

declare(strict_types=1);


namespace Tests\Unit\Collectible\Infrastructure\Persistance\Postgresql;

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

  public function testSaveUpdateWhenDoesExist(): void 
  {
    $collectible = CollectibleStub::fixture();

    $this->collectiblePostgresqlRepository->save($collectible);

    $this->assertSame($collectible->toArray(), $this->collectiblePostgresqlRepository->findById($collectible->id())->toArray());
  }

  public function testDeleteWhenDoesExist(): void 
  {
    $preDeleteCount = count($this->collectiblePostgresqlRepository->findAll());
    $collectible = CollectibleStub::fixture();
    $this->collectiblePostgresqlRepository->delete($collectible->id());

    $this->assertCount($preDeleteCount - 1, $this->collectiblePostgresqlRepository->findAll());
  }

  public function testDeleteWhenDoesNotExist(): void 
  {
    $preDeleteCount = count($this->collectiblePostgresqlRepository->findAll());
    $collectible = CollectibleStub::random();
    $this->collectiblePostgresqlRepository->delete($collectible->id());

    $this->assertCount($preDeleteCount, $this->collectiblePostgresqlRepository->findAll());
  }

  public function testFindByIdWhenDoesExist(): void 
  {
    $collectible = CollectibleStub::fixture();
    $this->assertEquals($collectible->toArray(), $this->collectiblePostgresqlRepository->findById($collectible->id())->toArray());
  }

  public function testFindByIdWhenDoesNotExist(): void 
  {
    $collectible = CollectibleStub::random();
    $this->assertNull($this->collectiblePostgresqlRepository->findById($collectible->id()));
  }
} 