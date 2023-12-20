<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Application;

use App\Collectible\Application\GetCollectiblesQuery;
use App\Collectible\Application\GetCollectiblesQueryHandler;
use App\Collectible\Domain\Repository\CollectibleRepository;
use Tests\Unit\Collectible\Domain\Aggregate\CollectibleMother;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GetCollectiblesQueryHandlerTest extends TestCase
{
  private CollectibleRepository|MockObject $collectibleRepository;
  private GetCollectiblesQueryHandler $getCollectiblesQueryHandler;

  public function setUp(): void
  {
    $this->collectibleRepository = $this->createMock(CollectibleRepository::class);
    $this->getCollectiblesQueryHandler = new GetCollectiblesQueryHandler($this->collectibleRepository);
  }

  public function testFindAllIsCalled(): void
  {
    $collectibles = [
      $collectible = CollectibleMother::createRandom(),
      $collectible = CollectibleMother::createRandom()
    ];
    $this->collectibleRepository->expects($this->once())->method('findAll')->willReturn($collectibles);

    $this->getCollectiblesQueryHandler->execute(GetCollectiblesQuery::create());
  }

  public function testCollectiblesAreReturned(): void
  {
    $collectibles = [
      $collectible = CollectibleMother::createRandom(),     
      $collectible = CollectibleMother::createRandom()

    ];
    $this->collectibleRepository->method('findAll')->willReturn($collectibles);

    $result = $this->getCollectiblesQueryHandler->execute(GetCollectiblesQuery::create());

    $this->assertEquals($collectibles, $result);
  }

  public function testEmptyArrayIsReturnedIfNoCollection(): void
  {
    $this->collectibleRepository->method('findAll')->willReturn([]);

    $result = $this->getCollectiblesQueryHandler->execute(GetCollectiblesQuery::create());

    $this->assertEquals([], $result);
  }
}