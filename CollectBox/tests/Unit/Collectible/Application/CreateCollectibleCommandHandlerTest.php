<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Application;

use App\Collectible\Application\CreateCollectibleCommand;
use App\Collectible\Application\CreateCollectibleCommandHandler;
use App\Collectible\Domain\Repository\CollectibleRepository;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\Infrastructure\Context\Collectible\Domain\Aggregate\CollectibleStub;
use Tests\Infrastructure\TestCase\BaseTestCase;

class CreateCollectibleCommandHandlerTest extends BaseTestCase
{
  private CollectibleRepository|MockObject $collectibleRepository;
  private CreateCollectibleCommandHandler $createCollectibleCommandHandler;

  public function setUp(): void
  {
    $this->collectibleRepository = $this->createMock(CollectibleRepository::class);
    $this->createCollectibleCommandHandler = new CreateCollectibleCommandHandler($this->collectibleRepository);
  }

  public function testSaveIsCalled(): void
  {
    $collectible = CollectibleStub::random();
    $this->collectibleRepository->expects($this->once())->method('save');

    $this->createCollectibleCommandHandler->execute(
      CreateCollectibleCommand::create(
        $collectible->code()->value(),
        $collectible->name()->value(),
        $collectible->url()->value()
      )
    );
  }

  public function testCollectibleIsReturned(): void
  {
    $collectible = CollectibleStub::random();
    $this->collectibleRepository->method('save')->willReturn($collectible);

    $result = $this->createCollectibleCommandHandler->execute(
      CreateCollectibleCommand::create(
        $collectible->code()->value(), 
        $collectible->name()->value(),
        $collectible->url()->value()
      )
    );
    
    $this->assertEquals($collectible, $result);
  }
}