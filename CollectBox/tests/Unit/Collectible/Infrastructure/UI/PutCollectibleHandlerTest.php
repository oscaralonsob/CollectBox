<?php

declare(strict_types=1);

namespace Tests\Unit\Collectible\Infrastructure\UI;

use App\Collectible\Application\PutCollectibleCommandHandler;
use App\Collectible\Domain\Exception\CollectibleCodeInvalidException;
use App\Collectible\Domain\Exception\CollectibleNameInvalidException;
use App\Collectible\Domain\Exception\CollectibleNotFoundException;
use App\Collectible\Domain\Exception\CollectibleUrlInvalidException;
use App\Collectible\Infrastructure\UI\PutCollectibleHandler;
use App\Shared\Domain\Exception\NonEmptyStringInvalidException;
use App\Shared\Domain\Exception\UuidInvalidException;
use Exception;
use PHPUnit\Framework\MockObject\Generator\InvalidMethodNameException;
use Tests\Unit\Collectible\Domain\Aggregate\CollectibleMother;
use PHPUnit\Framework\MockObject\MockObject;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class PutCollectibleHandlerTest extends TestCase
{
  private ServerRequestInterface|MockObject $request;
  private PutCollectibleCommandHandler|MockObject $putCollectibleCommandHandler;
  private PutCollectibleHandler $putCollectibleHandler;

  public function setUp(): void
  {
    $this->request = $this->createMock(ServerRequestInterface::class);
    $this->putCollectibleCommandHandler = $this->createMock(PutCollectibleCommandHandler::class);
    $this->putCollectibleHandler = new PutCollectibleHandler($this->putCollectibleCommandHandler);
  }

  public function testHandlerReturn200(): void
  {
    $collectible = CollectibleMother::createRandom();
    $this->request->method('getAttribute')->willReturn($collectible->id()->value());
    $this->request->method('getParsedBody')->willReturn([
      'name' => $collectible->name()->value(),
      'url' => $collectible->url()->value(),
    ]);
    $this->putCollectibleCommandHandler->method('execute')->willReturn($collectible);

    $response = $this->putCollectibleHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testHandlerReturnCollectible(): void
  {
    $collectible = CollectibleMother::createRandom();
    $this->request->method('getAttribute')->willReturn($collectible->id()->value());
    $this->request->method('getParsedBody')->willReturn([
      'name' => $collectible->name()->value(),
      'url' => $collectible->url()->value(),
    ]);
    $this->putCollectibleCommandHandler->method('execute')->willReturn($collectible);

    $response = $this->putCollectibleHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals($collectible->toArray(), json_decode($response->getBody()->getContents(), true));
  }

  public function testHandlerReturn404WhenDoesNotExist(): void
  {    
    $collectible = CollectibleMother::createRandom();
    $this->putCollectibleCommandHandler->method('execute')->willThrowException(CollectibleNotFoundException::create($collectible->id()));

    $response = $this->putCollectibleHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(404, $response->getStatusCode());
  }

  public function testHandlerReturn500WhenEmptyString(): void
  {
    $this->putCollectibleCommandHandler->method('execute')->willThrowException(NonEmptyStringInvalidException::create());

    $response = $this->putCollectibleHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(500, $response->getStatusCode());
  }

  public function testHandlerReturn500WhenInvalidId(): void
  {
    $this->putCollectibleCommandHandler->method('execute')->willThrowException(UuidInvalidException::create(""));

    $response = $this->putCollectibleHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(500, $response->getStatusCode());
  }

  public function testHandlerReturn500WhenInvalidName(): void
  {
    $this->putCollectibleCommandHandler->method('execute')->willThrowException(CollectibleNameInvalidException::create(""));

    $response = $this->putCollectibleHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(500, $response->getStatusCode());
  }

  public function testHandlerReturn500WhenInvalidCode(): void
  {
    $this->putCollectibleCommandHandler->method('execute')->willThrowException(CollectibleCodeInvalidException::create(""));

    $response = $this->putCollectibleHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(500, $response->getStatusCode());
  }

  public function testHandlerReturn500WhenInvalidUrl(): void
  {
    $this->putCollectibleCommandHandler->method('execute')->willThrowException(CollectibleUrlInvalidException::create(""));

    $response = $this->putCollectibleHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(500, $response->getStatusCode());
  }

  public function testHandlerReturn500WhenGeneric(): void
  {
    $this->putCollectibleCommandHandler->method('execute')->willThrowException(new Exception());

    $response = $this->putCollectibleHandler->handle($this->request);
    $response->getBody()->rewind();

    $this->assertEquals(500, $response->getStatusCode());
  }
}