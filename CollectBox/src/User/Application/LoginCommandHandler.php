<?php

declare(strict_types=1);

namespace App\User\Application;

use App\User\Domain\Aggregate\User;
use App\User\Domain\Entity\UserName;
use App\User\Domain\Repository\UserRepository;

class LoginCommandHandler
{
  public function __construct(private UserRepository $userRepository)
  {
  }

  public function execute(LoginCommand $command): ?User
  {
    $user = $this->userRepository->searchByUserName(UserName::create($command->userName()));

    if ($user?->password()->value() != $command->password()) {
      return null;
    }
  
    return $user;
  }
}