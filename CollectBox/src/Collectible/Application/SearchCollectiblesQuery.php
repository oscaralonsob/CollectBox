<?php

declare(strict_types=1);

namespace App\Collectible\Application;

class SearchCollectiblesQuery
{
  private function __construct() {}

  public static function create(): self
  {
    return new self();
  }
}