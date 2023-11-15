<?php

namespace App\Application\Collectible;

class DeleteCollectibleByIdCommand
{
  public function __construct(private int $id) {}

  public function id(): int
  {
    return $this->id;
  }
}