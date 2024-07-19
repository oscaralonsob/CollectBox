<?php

declare(strict_types=1);

namespace App\User\Domain\Aggregate;

use App\User\Domain\Entity\Password;
use App\User\Domain\Entity\UserId;
use App\User\Domain\Entity\UserName;

class User 
{
  private function __construct(
    private UserId $id,
    private UserName $userName,
    private Password $password
  ) {
  }
  
  public static function create(
    UserId $id,
    UserName $userName,
    Password $password
  ) {
    return new self($id, $userName, $password);
  }

  public function id(): UserId
  {
    return $this->id;
  }

  public function userName(): UserName
  {
    return $this->userName;
  }

  public function password(): Password
  {
    return $this->password;
  }

  public function toArray(): array
  {
    return [
      'id' => $this->id()->value(),
      'userName' => $this->userName()->value(),
      'password' => $this->password()->value(),
    ];
  }
}