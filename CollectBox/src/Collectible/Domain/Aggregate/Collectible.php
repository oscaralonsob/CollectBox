<?php

declare(strict_types=1);

namespace App\Collectible\Domain\Aggregate;

use App\Collectible\Domain\Entity\CollectibleCode;
use App\Collectible\Domain\Entity\CollectibleId;
use App\Collectible\Domain\Entity\CollectibleName;
use App\Collectible\Domain\Entity\CollectibleUrl;

class Collectible 
{
  private function __construct(
    private CollectibleId $id,
    private CollectibleCode $code,
    private CollectibleName $name,
    private CollectibleUrl $url
  ) {
  }
  
  public static function create(
    CollectibleId $id,
    CollectibleCode $code,
    CollectibleName $name,
    CollectibleUrl $url
  ) {
    return new self($id, $code, $name, $url);
  }

  public function id(): CollectibleId
  {
    return $this->id;
  }

  public function code(): CollectibleCode
  {
    return $this->code;
  }

  public function name(): CollectibleName
  {
    return $this->name;
  }

  public function url(): CollectibleUrl
  {
    return $this->url;
  }

  public function toArray(): array
  {
    return [
      'id' => $this->id()->value(),
      'code' => $this->code()->value(),
      'name' => $this->name()->value(),
      'url' => $this->url()->value(),
    ];
  }
}