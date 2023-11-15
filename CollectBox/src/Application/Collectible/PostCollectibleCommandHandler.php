<?php

namespace App\Application\Collectible;

class PostCollectibleCommandHandler
{
  private array $collectibles = [
    1 => ["id" => 1, "name" => "Collectible 1", "rarity" => "Common"],
    2 => ["id" => 2, "name" => "Collectible 2", "rarity" => "Rare"]
  ];

  public function execute(PostCollectibleCommand $command): array
  {
    $newCollectibleId = max(array_keys($this->collectibles)) + 1;
    $collectible = [
      "id" => $newCollectibleId,
      "name" => $command->name(),
      "rarity" => $command->rarity()
    ];
    $this->collectibles[$newCollectibleId] = $collectible;

    return $collectible;
  }
}