<?php

declare(strict_types=1);


namespace Tests\Unit\Collectible\Infrastructure\Persistance\Postgresql;

use Tests\Unit\Collectible\Domain\Aggregate\CollectibleMother;
use Tests\BaseTestCase;

class CollectiblePostgresqlRepositoryTest extends BaseTestCase
{
  //TODO: Initialize database values here, calling the parent
  public function setUp(): void 
  {
    parent::setUp();

    $collectible = CollectibleMother::create();
    self::$collectiblePostgresqlRepository->save($collectible);
  }

  public function testSaveInsert(): void 
  {
    $collectible = CollectibleMother::createRandom();

    self::$collectiblePostgresqlRepository->save($collectible);

    $this->assertSame($collectible->toArray(), self::$collectiblePostgresqlRepository->findById($collectible->id())->toArray());
  }

  public function testSaveUpdateWhenDoesExist(): void 
  {
    $collectible = CollectibleMother::create();

    self::$collectiblePostgresqlRepository->save($collectible);

    $this->assertSame($collectible->toArray(), self::$collectiblePostgresqlRepository->findById($collectible->id())->toArray());
  }

  public function testDeleteWhenDoesExist(): void 
  {
    $preDeleteCount = count(self::$collectiblePostgresqlRepository->findAll());
    $collectible = CollectibleMother::create();
    self::$collectiblePostgresqlRepository->delete($collectible->id());

    $this->assertCount($preDeleteCount - 1, self::$collectiblePostgresqlRepository->findAll());
  }

  public function testDeleteWhenDoesNotExist(): void 
  {
    $preDeleteCount = count(self::$collectiblePostgresqlRepository->findAll());
    $collectible = CollectibleMother::createRandom();
    self::$collectiblePostgresqlRepository->delete($collectible->id());

    $this->assertCount($preDeleteCount, self::$collectiblePostgresqlRepository->findAll());
  }

  public function testFindByIdWhenDoesExist(): void 
  {
    $collectible = CollectibleMother::create();
    $this->assertEquals($collectible->toArray(), self::$collectiblePostgresqlRepository->findById($collectible->id())->toArray());
  }

  public function testFindByIdWhenDoesNotExist(): void 
  {
    $collectible = CollectibleMother::createRandom();
    $this->assertNull(self::$collectiblePostgresqlRepository->findById($collectible->id()));
  }
} 