<?php

declare(strict_types=1);

namespace App\User\Domain\Repository;

use App\Shared\Domain\Entity\Collection;
use App\User\Domain\Aggregate\User;
use App\User\Domain\Entity\UserId;

interface UserRepository
{
  public function save(User $user): User ;

  public function findAll(): Collection;

  public function findById(UserId $id): User;
} 