<?php

declare(strict_types=1);

namespace Tests\Unit\User\Application;

use App\User\Application\LoginCommand;
use App\User\Application\LoginCommandHandler;
use App\User\Domain\Repository\UserRepository;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\Infrastructure\TestCase\BaseTestCase;
use Tests\Infrastructure\User\Domain\Aggregate\UserStub;

class LoginCommandHandlerTest extends BaseTestCase
{
  private UserRepository|MockObject $userRepository;
  private LoginCommandHandler $loginCommandHandler;

  public function setUp(): void
  {
    $this->userRepository = $this->createMock(UserRepository::class);
    $this->loginCommandHandler = new LoginCommandHandler($this->userRepository);
  }

  public function testLoginIsSuccessful(): void
  {
    $user = UserStub::fixture();
    $this->userRepository->method('searchByUserName')->willReturn($user);

    $result = $this->loginCommandHandler->execute(
      LoginCommand::create(
        $user->userName()->value(),
        $user->password()->value()      
      )
    );

    $this->assertEquals($user, $result);
  }

  public function testUserNameNotFound(): void
  {
    $user = UserStub::fixture();
    $this->userRepository->method('searchByUserName')->willReturn(null);

    $result = $this->loginCommandHandler->execute(
      LoginCommand::create(
        $user->userName()->value(),
        $user->password()->value()      
      )
    );

    $this->assertEmpty($result);
  }

  public function testPasswordNotMatch(): void
  {
    $user = UserStub::random();
    $this->userRepository->method('searchByUserName')->willReturn(UserStub::fixture());

    $result = $this->loginCommandHandler->execute(
      LoginCommand::create(
        $user->userName()->value(),
        $user->password()->value()      
      )
    );

    $this->assertEmpty($result);
  }
}