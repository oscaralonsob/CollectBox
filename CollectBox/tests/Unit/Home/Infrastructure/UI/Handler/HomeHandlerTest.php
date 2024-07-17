<?php

declare(strict_types=1);

namespace Tests\Unit\Home\Infrastructure\UI\Handler;

use App\Home\Infrastructure\UI\Handler\HomeHandler;
use Psr\Http\Message\ServerRequestInterface;
use Tests\Infrastructure\TestCase\BaseTestCase;

class HomeHandlerTest extends BaseTestCase
{
  public function testHandlerReturnHello(): void
  {
    $homeHandler = new HomeHandler();
    $request = $this->createMock(ServerRequestInterface::class);

    $response = $homeHandler->handle($request);
    $response->getBody()->rewind();

    $this->assertEquals("Hello", json_decode($response->getBody()->getContents(), true)["msg"]);
  }
}