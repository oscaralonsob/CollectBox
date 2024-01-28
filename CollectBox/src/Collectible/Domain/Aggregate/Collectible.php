<?php

declare(strict_types=1);

namespace App\Collectible\Domain\Aggregate;

use App\Collectible\Domain\Entity\CollectibleName;
use App\Collectible\Domain\Entity\CollectibleUrl;
use App\Shared\Domain\Entity\ValueObject\DomainId;

class Collectible 
{
  private function __construct(
    private DomainId $id,
    private CollectibleName $name,
    private CollectibleUrl $url
  ) {
  }
  
  public static function create(
    DomainId $id,
    CollectibleName $name,
    CollectibleUrl $url
  ) {
    return new self($id, $name, $url);
  }

  public function id(): DomainId
  {
    return $this->id;
  }

  public function name(): CollectibleName
  {
    return $this->name;
  }

  public function url(): CollectibleUrl
  {
    return $this->url;
  }

  public function rename(CollectibleName $value): Collectible
  {
    $this->name = $value;

    return $this;
  }

  public function changeUrl(CollectibleUrl $value): Collectible
  {
    $this->url = $value;

    return $this;
  }

  public function toArray(): array
  {
    return [
      'id' => $this->id()->value(),
      'name' => $this->name()->value(),
      'url' => $this->url()->value(),
    ];
  }
}