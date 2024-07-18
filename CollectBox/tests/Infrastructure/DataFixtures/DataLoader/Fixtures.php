<?php

declare(strict_types=1);

namespace Tests\Infrastructure\DataFixtures\DataLoader;

use PDO;

interface Fixtures
{
  //UP and down
  public function load(PDO $pdo): void;
  public function purge(PDO $pdo): void;
}