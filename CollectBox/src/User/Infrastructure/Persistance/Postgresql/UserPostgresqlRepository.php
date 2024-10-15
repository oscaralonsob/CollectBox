<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Persistance\Postgresql;

use App\Shared\Domain\Entity\Collection;
use App\User\Domain\Aggregate\User;
use App\User\Domain\Entity\Password;
use App\User\Domain\Entity\UserCollection;
use App\User\Domain\Entity\UserId;
use App\User\Domain\Entity\UserName;
use App\User\Domain\Exception\UserNotFoundException;
use App\User\Domain\Repository\UserRepository;
use PDO;

class UserPostgresqlRepository implements UserRepository
{
  public function __construct(private PDO $pdo)
  {
  }

  public function save(User $user): User 
  {
    $stmt = $this->pdo->prepare(
      "INSERT INTO user_account (id, user_name, password) 
            VALUES (:id, :userName, :password)"
    );
      
    $stmt->execute($this->fromObject($user));
    return $user;
  }

  //TODO: add criteria. Should be search
  public function findAll(): Collection
  {
    $stmt = $this->pdo->prepare("SELECT * FROM user_account");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_OBJ);

    $collection = UserCollection::empty();
    foreach ($users as $user) {
      $collection->add(
        $this->toObject($user)
      );
    }
    
    return $collection;
  }

  public function findById(UserId $id): User 
  {
    $stmt = $this->pdo->prepare("SELECT * FROM user_account WHERE id = :id");
    $stmt->execute(["id" => $id->value()]);
    $user = $stmt->fetch(PDO::FETCH_OBJ);

    if (!$user) {
      throw UserNotFoundException::create($id);
    }
    
    return $this->toObject($user);
  }

  public function searchByUserName(UserName $userName): ?User 
  {
    $stmt = $this->pdo->prepare("SELECT * FROM user_account WHERE user_name = :userName");
    $stmt->execute(["userName" => $userName->value()]);
    $users = $stmt->fetchAll(PDO::FETCH_OBJ);

    if (count($users) == 0) {
      return null;//TODO: Exception
    }
    
    return $this->toObject(current($users));
  }

  private function toObject(object $user): User
  {
    return User::create(
      UserId::create($user->id), 
      UserName::create($user->user_name), 
      Password::create($user->password)
    );
  }

  private function fromObject(User $user): array
  {
    return [
      "id" => $user->id()->value(),
      "userName" => $user->userName()->value(),
      "password" => $user->password()->value(),
    ];
  }
}