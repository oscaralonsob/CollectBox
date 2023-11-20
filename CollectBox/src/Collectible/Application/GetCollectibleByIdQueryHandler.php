<?php

declare(strict_types=1);

namespace App\Collectible\Application;

class GetCollectibleByIdQueryHandler
{
  private array $collectibles = [
    1 => ["id" => 1, "name" => "Collectible 1", "rarity" => "Common"],
    2 => ["id" => 2, "name" => "Collectible 2", "rarity" => "Rare"]
  ];

  public function execute(GetCollectibleByIdQuery $query): array
  {
    return $this->collectibles[$query->id()] ?? [];
  }
}