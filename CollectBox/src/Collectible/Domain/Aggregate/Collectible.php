<?php

declare(strict_types=1);

namespace App\Collectible\Domain\Aggregate;

use App\Shared\Domain\Entity\ValueObject\DomainId;

class Collectible 
{
  private function __construct(
    private DomainId $id,
    private string $name,
    private string $rarity
  ) {
  }
  
  public static function create(
    DomainId $id,
    string $name,
    string $rarity
  ) {
    return new self($id, $name, $rarity);
  }

  public function id(): DomainId
  {
    return $this->id;
  }

  public function name(): string
  {
    return $this->name;
  }

  public function rarity(): string
  {
    return $this->rarity;
  }

  public function toArray(): array
  {
    return [
      'id' => $this->id()->value(),
      'name' => $this->name(),
      'rarity' => $this->rarity(),
    ];
  }
}