<?php

declare(strict_types=1);

namespace App\User\Domain\Repository;

use App\Shared\Domain\Entity\Collection;
use App\User\Domain\Aggregate\User;
use App\User\Domain\Entity\UserId;
use App\User\Domain\Entity\UserName;

interface UserRepository
{
  public function save(User $user): User ;

  public function findAll(): Collection;

  public function findById(UserId $id): User;

  //TODO: criteria
  public function searchByUserName(UserName $userName): ?User;
} 