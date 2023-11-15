<?php

namespace App\Application\Collectible;

class GetCollectiblesQueryHandler
{
  private array $collectibles = [
    1 => ["id" => 1, "name" => "Collectible 1", "rarity" => "Common"],
    2 => ["id" => 2, "name" => "Collectible 2", "rarity" => "Rare"]
  ];

  public function execute(GetCollectiblesQuery $query): array
  {
    return $this->collectibles;
  }
}