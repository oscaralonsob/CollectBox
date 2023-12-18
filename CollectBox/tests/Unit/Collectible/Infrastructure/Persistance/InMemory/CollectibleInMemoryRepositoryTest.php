<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Infrastructure\Persistance\InMemory;

use App\Collectible\Domain\Aggregate\Collectible;
use App\Collectible\Infrastructure\Persistance\InMemory\CollectibleInMemoryRepository;
use App\Shared\Domain\Entity\ValueObject\DomainId;
use App\Shared\Domain\Entity\ValueObject\NonEmptyString;
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
    $collectible = Collectible::create(DomainId::createRandom(), NonEmptyString::create("testName"), NonEmptyString::create("testRarity"));

    $this->collectibleInMemoryRepository->save($collectible);

    $this->assertCount(3, $this->collectibleInMemoryRepository->findAll());
  }

  public function testSaveUpdateWhenDoesExist(): void 
  {
    $id = DomainId::create("7982e692-dd0b-49c6-a08c-0776b39e9e6c");
    $collectible = Collectible::create($id, NonEmptyString::create("testName"), NonEmptyString::create("testRarity"));

    $this->collectibleInMemoryRepository->save($collectible);

    $this->assertSame($collectible->toArray(), $this->collectibleInMemoryRepository->findById($id)->toArray());
  }

  public function testDeleteWhenDoesExist(): void 
  {
    $id = DomainId::create("7982e692-dd0b-49c6-a08c-0776b39e9e6c");
    $this->collectibleInMemoryRepository->delete($id);

    $this->assertCount(1, $this->collectibleInMemoryRepository->findAll());
  }

  public function testDeleteWhenDoesNotExist(): void 
  {
    $this->collectibleInMemoryRepository->delete(DomainId::createRandom());

    $this->assertCount(2, $this->collectibleInMemoryRepository->findAll());
  }

  public function testFindAll(): void 
  {
    $this->assertCount(2, $this->collectibleInMemoryRepository->findAll());
  }

  public function testFindByIdWhenDoesExist(): void 
  {
    $id = DomainId::create("ae8c868b-48cd-4457-9f2f-4c3f0d3d41a0");
    $collectible = Collectible::create($id, NonEmptyString::create("Collectible 1"), NonEmptyString::create("Common"));
    $this->assertEquals($collectible->toArray(), $this->collectibleInMemoryRepository->findById($id)->toArray());
  }

  public function testFindByIdWhenDoesNotExist(): void 
  {
    $this->assertNull($this->collectibleInMemoryRepository->findById(DomainId::createRandom()));
  }
} 