<?php

namespace App\Collectible\Domain\Exception;

use App\Shared\Domain\Entity\ValueObject\DomainId;
use Exception;

final class CollectibleNotFoundException extends Exception
{
  private const EXCEPTION_MESSAGE = "Collectible with Uuid  %s was not found";

  public static function create(DomainId $id) {
    return new static(sprintf(static::EXCEPTION_MESSAGE, $id->value()));
  }
}
