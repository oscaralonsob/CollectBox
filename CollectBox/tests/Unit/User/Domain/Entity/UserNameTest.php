<?php

declare(strict_types=1);

namespace Tests\Unit\User\Domain\Entity;

use App\User\Domain\Entity\UserName;
use App\User\Domain\Exception\UserNameInvalidException;
use Tests\Infrastructure\TestCase\BaseTestCase;

class UserNameTest extends BaseTestCase
{
  public function testCreate(): void
  {
    $userName = UserName::create("Name test");

    $this->assertNotNull($userName);
  }

  public function testCreateFromInvalid(): void
  {
    $this->expectException(UserNameInvalidException::class);

    UserName::create("this is for sure a string longer than 50 characters");
  }
}