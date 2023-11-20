<?php

declare(strict_types=1);

namespace App\Collectible\Application;

class DeleteCollectibleByIdCommandHandler
{
  private const ID = "id"; 

  private array $collectibles = [
    1 => ["id" => 1, "name" => "Collectible 1", "rarity" => "Common"],
    2 => ["id" => 2, "name" => "Collectible 2", "rarity" => "Rare"]
  ];

  public function execute(DeleteCollectibleByIdCommand $command): array
  {
    if (isset($this->collectibles[$command->id()])) {
      unset($this->collectibles[$command->id()]);
    }

    return [self::ID => $command->id()];
  }
}