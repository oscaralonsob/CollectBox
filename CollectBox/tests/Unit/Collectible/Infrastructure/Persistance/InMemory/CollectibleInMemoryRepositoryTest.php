<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Infrastructure\Persistance\InMemory;

use App\Collectible\Infrastructure\Persistance\InMemory\CollectibleInMemoryRepository;
use PHPUnit\Framework\TestCase;
use Tests\Infrastructure\Collectible\Domain\Aggregate\CollectibleStub;

class CollectibleInMemoryRepositoryTest extends TestCase
{
  private CollectibleInMemoryRepository $collectibleInMemoryRepository;

  public function setUp(): void
  {
    $this->collectibleInMemoryRepository = new CollectibleInMemoryRepository();
  }

  public function testSaveInsert(): void 
  {
    $collectible = CollectibleStub::random();

    $this->collectibleInMemoryRepository->save($collectible);

    $this->assertCount(3, $this->collectibleInMemoryRepository->findAll());
  }

  public function testSaveUpdateWhenDoesExist(): void 
  {
    $collectible = CollectibleStub::fixture();

    $this->collectibleInMemoryRepository->save($collectible);

    $this->assertSame($collectible->toArray(), $this->collectibleInMemoryRepository->findById($collectible->id())->toArray());
  }

  public function testDeleteWhenDoesExist(): void 
  {
    $collectible = CollectibleStub::fixture();
    $this->collectibleInMemoryRepository->delete($collectible->id());

    $this->assertCount(1, $this->collectibleInMemoryRepository->findAll());
  }

  public function testDeleteWhenDoesNotExist(): void 
  {
    $collectible = CollectibleStub::random();
    $this->collectibleInMemoryRepository->delete($collectible->id());

    $this->assertCount(2, $this->collectibleInMemoryRepository->findAll());
  }

  public function testFindAll(): void 
  {
    $this->assertCount(2, $this->collectibleInMemoryRepository->findAll());
  }

  public function testFindByIdWhenDoesExist(): void 
  {
    $collectible = CollectibleStub::fixture();
    $this->assertEquals($collectible->toArray(), $this->collectibleInMemoryRepository->findById($collectible->id())->toArray());
  }

  public function testFindByIdWhenDoesNotExist(): void 
  {
    $collectible = CollectibleStub::random();
    $this->assertNull($this->collectibleInMemoryRepository->findById($collectible->id()));
  }
} 