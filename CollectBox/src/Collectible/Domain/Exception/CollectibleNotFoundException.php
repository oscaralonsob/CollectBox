<?php

namespace App\Collectible\Domain\Exception;

use App\Collectible\Domain\Entity\CollectibleId;
use Exception;

final class CollectibleNotFoundException extends Exception
{
  private const EXCEPTION_MESSAGE = "Collectible with Uuid  %s was not found";

  public static function create(CollectibleId $id) {
    return new static(sprintf(static::EXCEPTION_MESSAGE, $id->value()));
  }
}
