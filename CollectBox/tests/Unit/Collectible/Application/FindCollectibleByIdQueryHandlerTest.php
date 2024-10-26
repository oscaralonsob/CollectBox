<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Application;

use App\Collectible\Application\FindCollectibleByIdQuery;
use App\Collectible\Application\FindCollectibleByIdQueryHandler;
use App\Collectible\Domain\Exception\CollectibleNotFoundException;
use App\Collectible\Domain\Repository\CollectibleRepository;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\Infrastructure\Context\Collectible\Domain\Aggregate\CollectibleStub;
use Tests\Infrastructure\TestCase\BaseTestCase;

class FindCollectibleByIdQueryHandlerTest extends BaseTestCase
{
  private CollectibleRepository|MockObject $collectibleRepository;
  private FindCollectibleByIdQueryHandler $findCollectibleByIdQueryHandler;

  public function setUp(): void
  {
    $this->collectibleRepository = $this->createMock(CollectibleRepository::class);
    $this->findCollectibleByIdQueryHandler = new FindCollectibleByIdQueryHandler($this->collectibleRepository);
  }

  public function testFindByIdIsCalled(): void
  {
    $collectible = CollectibleStub::random();
    $this->collectibleRepository->expects($this->once())->method('findById')->willReturn($collectible);

    $this->findCollectibleByIdQueryHandler->execute(FindCollectibleByIdQuery::create($collectible->id()->value()));
  }

  public function testACollectibleIsReturned(): void
  {
    $collectible = CollectibleStub::random();
    $this->collectibleRepository->method('findById')->willReturn($collectible);

    $result = $this->findCollectibleByIdQueryHandler->execute(FindCollectibleByIdQuery::create($collectible->id()->value()));

    $this->assertEquals($collectible, $result);
  }

  public function testErrorIsThrowIfCollectibleIsNotFound(): void
  {
    $this->expectException(CollectibleNotFoundException::class);
    $collectible = CollectibleStub::random();
    $this->collectibleRepository->method('findById')->willThrowException(CollectibleNotFoundException::create($collectible->id()));

    $result = $this->findCollectibleByIdQueryHandler->execute(FindCollectibleByIdQuery::create($collectible->id()->value()));
  }
}