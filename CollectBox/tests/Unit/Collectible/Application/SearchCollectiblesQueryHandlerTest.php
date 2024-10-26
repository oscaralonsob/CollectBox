<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Application;

use App\Collectible\Application\SearchCollectiblesQuery;
use App\Collectible\Application\SearchCollectiblesQueryHandler;
use App\Collectible\Domain\Repository\CollectibleRepository;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\Infrastructure\Context\Collectible\Domain\Entity\CollectibleCollectionStub;
use Tests\Infrastructure\TestCase\BaseTestCase;

class SearchCollectiblesQueryHandlerTest extends BaseTestCase
{
  private CollectibleRepository|MockObject $collectibleRepository;
  private SearchCollectiblesQueryHandler $searchCollectiblesQueryHandler;

  public function setUp(): void
  {
    $this->collectibleRepository = $this->createMock(CollectibleRepository::class);
    $this->searchCollectiblesQueryHandler = new SearchCollectiblesQueryHandler($this->collectibleRepository);
  }

  public function testFindAllIsCalled(): void
  {
    $collectibles = CollectibleCollectionStub::random();
    $this->collectibleRepository->expects($this->once())->method('findAll')->willReturn($collectibles);

    $this->searchCollectiblesQueryHandler->execute(SearchCollectiblesQuery::create());
  }

  public function testCollectiblesAreReturned(): void
  {
    $collectibles = CollectibleCollectionStub::random();
    $this->collectibleRepository->method('findAll')->willReturn($collectibles);

    $result = $this->searchCollectiblesQueryHandler->execute(SearchCollectiblesQuery::create());

    $this->assertEquals($collectibles, $result);
  }

  public function testEmptyArrayIsReturnedIfNoCollection(): void
  {
    $this->collectibleRepository->method('findAll')->willReturn(CollectibleCollectionStub::empty());

    $result = $this->searchCollectiblesQueryHandler->execute(SearchCollectiblesQuery::create());

    $this->assertEquals([], $result->toArray());
  }
}