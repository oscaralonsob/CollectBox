<?php

declare(strict_types=1);

namespace App\Collectible\Domain\Aggregate;

use App\Shared\Domain\Entity\ValueObject\DomainId;
use App\Shared\Domain\Entity\ValueObject\NonEmptyString;

class Collectible 
{
  private function __construct(
    private DomainId $id,
    private NonEmptyString $name,
    private NonEmptyString $rarity
  ) {
  }
  
  public static function create(
    DomainId $id,
    NonEmptyString $name,
    NonEmptyString $rarity
  ) {
    return new self($id, $name, $rarity);
  }

  public function id(): DomainId
  {
    return $this->id;
  }

  public function name(): NonEmptyString
  {
    return $this->name;
  }

  public function rarity(): NonEmptyString
  {
    return $this->rarity;
  }

  public function toArray(): array
  {
    return [
      'id' => $this->id()->value(),
      'name' => $this->name()->value(),
      'rarity' => $this->rarity()->value(),
    ];
  }
}