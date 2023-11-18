<?php

declare(strict_types=1);

namespace App\Application\Collectible;

class GetCollectiblesQuery
{
  private function __construct() {}

  public static function create(): self
  {
    return new self();
  }
}