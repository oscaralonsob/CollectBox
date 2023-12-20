<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Infrastructure\Persistance\InMemory;

use App\Collectible\Infrastructure\Persistance\InMemory\CollectibleInMemoryRepository;
use Tests\Unit\Collectible\Domain\Aggregate\CollectibleMother;
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
    $collectible = CollectibleMother::createRandom();

    $this->collectibleInMemoryRepository->save($collectible);

    $this->assertCount(3, $this->collectibleInMemoryRepository->findAll());
  }

  public function testSaveUpdateWhenDoesExist(): void 
  {
    $collectible = CollectibleMother::create();

    $this->collectibleInMemoryRepository->save($collectible);

    $this->assertSame($collectible->toArray(), $this->collectibleInMemoryRepository->findById($collectible->id())->toArray());
  }

  public function testDeleteWhenDoesExist(): void 
  {
    $collectible = CollectibleMother::create();
    $this->collectibleInMemoryRepository->delete($collectible->id());

    $this->assertCount(1, $this->collectibleInMemoryRepository->findAll());
  }

  public function testDeleteWhenDoesNotExist(): void 
  {
    $collectible = CollectibleMother::createRandom();
    $this->collectibleInMemoryRepository->delete($collectible->id());

    $this->assertCount(2, $this->collectibleInMemoryRepository->findAll());
  }

  public function testFindAll(): void 
  {
    $this->assertCount(2, $this->collectibleInMemoryRepository->findAll());
  }

  public function testFindByIdWhenDoesExist(): void 
  {
    $collectible = CollectibleMother::create();
    $this->assertEquals($collectible->toArray(), $this->collectibleInMemoryRepository->findById($collectible->id())->toArray());
  }

  public function testFindByIdWhenDoesNotExist(): void 
  {
    $collectible = CollectibleMother::createRandom();
    $this->assertNull($this->collectibleInMemoryRepository->findById($collectible->id()));
  }
} 