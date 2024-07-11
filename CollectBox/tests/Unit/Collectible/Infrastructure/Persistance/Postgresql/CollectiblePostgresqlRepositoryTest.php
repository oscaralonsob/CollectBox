<?php

declare(strict_types=1);


namespace Tests\Unit\Collectible\Infrastructure\Persistance\Postgresql;

use Tests\BaseTestCase;
use Tests\Infrastructure\Collectible\Domain\Aggregate\CollectibleStub;

class CollectiblePostgresqlRepositoryTest extends BaseTestCase
{
  public function setUp(): void 
  {
    parent::setUp();
  }

  public function testSaveInsert(): void 
  {
    $collectible = CollectibleStub::random();

    self::$collectiblePostgresqlRepository->save($collectible);

    $this->assertSame($collectible->toArray(), self::$collectiblePostgresqlRepository->findById($collectible->id())->toArray());
  }

  public function testSaveUpdateWhenDoesExist(): void 
  {
    $collectible = CollectibleStub::fixture();

    self::$collectiblePostgresqlRepository->save($collectible);

    $this->assertSame($collectible->toArray(), self::$collectiblePostgresqlRepository->findById($collectible->id())->toArray());
  }

  public function testDeleteWhenDoesExist(): void 
  {
    $preDeleteCount = count(self::$collectiblePostgresqlRepository->findAll());
    $collectible = CollectibleStub::fixture();
    self::$collectiblePostgresqlRepository->delete($collectible->id());

    $this->assertCount($preDeleteCount - 1, self::$collectiblePostgresqlRepository->findAll());
  }

  public function testDeleteWhenDoesNotExist(): void 
  {
    $preDeleteCount = count(self::$collectiblePostgresqlRepository->findAll());
    $collectible = CollectibleStub::random();
    self::$collectiblePostgresqlRepository->delete($collectible->id());

    $this->assertCount($preDeleteCount, self::$collectiblePostgresqlRepository->findAll());
  }

  public function testFindByIdWhenDoesExist(): void 
  {
    $collectible = CollectibleStub::fixture();
    $this->assertEquals($collectible->toArray(), self::$collectiblePostgresqlRepository->findById($collectible->id())->toArray());
  }

  public function testFindByIdWhenDoesNotExist(): void 
  {
    $collectible = CollectibleStub::random();
    $this->assertNull(self::$collectiblePostgresqlRepository->findById($collectible->id()));
  }
} 