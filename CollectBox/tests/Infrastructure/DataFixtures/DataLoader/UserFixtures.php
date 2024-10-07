<?php

declare(strict_types=1);

namespace Tests\Infrastructure\DataFixtures\DataLoader;

use App\User\Domain\Aggregate\User;
use App\User\Domain\Entity\Password;
use App\User\Domain\Entity\UserId;
use App\User\Domain\Entity\UserName;
use PDO;
use Symfony\Component\Yaml\Yaml;

class UserFixtures implements Fixtures
{
  public function load(PDO $pdo): void
  {
    foreach (Yaml::parseFile('tests/Infrastructure/DataFixtures/Fixtures/users.yaml')['user'] as $userFixture) {
      $user = User::create(
        UserId::create($userFixture['id']),
        UserName::create($userFixture['userName']),
        Password::create($userFixture['password'])
      );

      $stmt = $pdo->prepare(
        "INSERT INTO user_account (id, user_name, password) 
              VALUES (:id, :userName, :password)"
      );
        
      $stmt->execute([
        "id" => $user->id()->value(),
        "userName" => $user->userName()->value(),
        "password" => $user->password()->value(),
      ]);
    }
  }

  public function purge(PDO $pdo): void
  {
    $stmt = $pdo->prepare("DELETE FROM user_account");
    $stmt->execute();
  }
}