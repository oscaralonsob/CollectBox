<?php

declare(strict_types=1);

namespace App\Collectible\Application;

class PutCollectibleCommandHandler
{
  private array $collectibles = [
    1 => ["id" => 1, "name" => "Collectible 1", "rarity" => "Common"],
    2 => ["id" => 2, "name" => "Collectible 2", "rarity" => "Rare"]
  ];

  public function execute(PutCollectibleCommand $command): array
  {
    if (isset($this->collectibles[$command->id()])) {
      $this->collectibles[$command->id()] = [
        "id" => $command->id(),
        "name" => $command->name() ?? $this->collectibles[$command->id()]["name"],
        "rarity" => $command->rarity() ?? $this->collectibles[$command->id()]["rarity"],
      ];
     return $this->collectibles[$command->id()];  
    }
    
    return [];  
  }
}