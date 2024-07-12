<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Collectible\Domain\Aggregate;

use App\Collectible\Domain\Aggregate\Collectible;
use App\Collectible\Domain\Entity\CollectibleCode;
use App\Collectible\Domain\Entity\CollectibleName;
use App\Collectible\Domain\Entity\CollectibleUrl;
use App\Shared\Domain\Entity\ValueObject\DomainId;
use Tests\Infrastructure\Collectible\Domain\Entity\CollectibleCodeStub;
use Tests\Infrastructure\Collectible\Domain\Entity\CollectibleIdStub;
use Tests\Infrastructure\Collectible\Domain\Entity\CollectibleNameStub;
use Tests\Infrastructure\Collectible\Domain\Entity\CollectibleUrlStub;

class CollectibleStub
{
  public static function random(
    ?DomainId $id = null,
    ?CollectibleCode $code = null,
    ?CollectibleName $name = null,
    ?CollectibleUrl $url = null
  ): Collectible {
    return Collectible::create(
      $id ?? CollectibleIdStub::random(), 
      $code ?? CollectibleCodeStub::random(), 
      $name ?? CollectibleNameStub::random(), 
      $url ?? CollectibleUrlStub::random()
    );
  }

  public static function fixture(): Collectible {
    return Collectible::create(
      DomainId::create("baca94a4-a209-45e1-be33-d079248122ee"),  
      CollectibleCode::create("B04-001SR"), 
      CollectibleName::create("Tsubasa Oribe: The Golden Idol"), 
      CollectibleUrl::createFromRelative("")
    );
  }

}