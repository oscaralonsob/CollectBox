<?php

declare(strict_types=1);


namespace Tests\Unit\User\Infrastructure\Persistance\Postgresql;

use App\User\Domain\Exception\UserNotFoundException;
use App\User\Infrastructure\Persistance\Postgresql\UserPostgresqlRepository;
use Tests\Infrastructure\DataFixtures\DataLoader\UserFixtures;
use Tests\Infrastructure\TestCase\RepositoryTestCase;
use Tests\Infrastructure\User\Domain\Aggregate\UserStub;

class UserPostgresqlRepositoryTest extends RepositoryTestCase
{
  protected function setUp(): void
  {
    $this->fixtureLoader()->addFixtures(new UserFixtures());
    parent::setUp();
  }

  public function testSaveInsert(): void 
  {
    $user = UserStub::random();

    $this->repository()->save($user);

    $this->assertSame($user->toArray(), $this->repository()->findById($user->id())->toArray());
  }

  public function testFindByIdWhenDoesExist(): void 
  {
    $user = UserStub::fixture();
    $this->assertEquals($user->toArray(), $this->repository()->findById($user->id())->toArray());
  }

  public function testFindByIdWhenDoesNotExist(): void 
  {
    $user = UserStub::random();
    $this->expectException(UserNotFoundException::class);
    $this->repository()->findById($user->id());
  }

  public function testFindAll(): void 
  {
    $this->assertCount(1, $this->repository()->findAll()->toArray());
  }

  public function testSearchByUserNameWhenDoesExist(): void 
  {
    $user = UserStub::fixture();
    $foundUser = $this->repository()->searchByUserName($user->userName());
    $this->assertEquals($user->toArray(), $foundUser->toArray());
  }

  public function testSearchByUserNameWhenDoesNotExist(): void 
  {
    $user = UserStub::random();
    $this->assertEmpty($this->repository()->searchByUserName($user->userName()));
  }

  public function repositoryClassName(): string
  {
    return UserPostgresqlRepository::class;
  }
} 