<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Infrastructure\Persistance\InMemory;

use App\Collectible\Domain\Aggregate\Collectible;
use App\Collectible\Infrastructure\Persistance\InMemory\CollectibleInMemoryRepository;
use PHPUnit\Framework\TestCase;

class CollectibleInMemoryRepositoryTest extends TestCase
{
  private CollectibleInMemoryRepository $collectibleInMemoryRepository;

  public function setUp(): void
  {
    $this->collectibleInMemoryRepository = new CollectibleInMemoryRepository();
  }

  public function testSaveInsert(): void 
  {
    $collectible = Collectible::create(0, "testName", "testRarity");

    $this->collectibleInMemoryRepository->save($collectible);

    $this->assertCount(3, $this->collectibleInMemoryRepository->findAll());
  }

  public function testSaveUpdateWhenDesExist(): void 
  {
    $collectible = Collectible::create(1, "testName", "testRarity");

    $this->collectibleInMemoryRepository->save($collectible);

    $this->assertSame($collectible->toArray(), $this->collectibleInMemoryRepository->findById(1)->toArray());
  }

  public function testSaveUpdateWhenDesNotExist(): void 
  {
    $collectible = Collectible::create(100, "testName", "testRarity");

    $response = $this->collectibleInMemoryRepository->save($collectible);

    $this->assertNull($response);
  }

  public function testDeleteWhenDoesExist(): void 
  {
    $this->collectibleInMemoryRepository->delete(1);

    $this->assertCount(1, $this->collectibleInMemoryRepository->findAll());
  }

  public function testDeleteWhenDoesNotExist(): void 
  {
    $this->collectibleInMemoryRepository->delete(100);

    $this->assertCount(2, $this->collectibleInMemoryRepository->findAll());
  }

  public function testFindAll(): void 
  {
    $this->assertCount(2, $this->collectibleInMemoryRepository->findAll());
  }

  public function testFindByIdWhenDesExist(): void 
  {
    $collectible = Collectible::create(1, "Collectible 1", "Common");
    $this->assertEquals($collectible->toArray(), $this->collectibleInMemoryRepository->findById(1)->toArray());
  }

  public function testFindByIdWhenDoesNotExist(): void 
  {
    $this->assertNull($this->collectibleInMemoryRepository->findById(100));
  }
} 