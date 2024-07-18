<?php

declare(strict_types=1);

namespace Tests\Infrastructure\DataFixtures\DataLoader;

use PDO;

class FixturesLoader
{
  private array $fixtures = [];

  public function __construct(private PDO $pdo)
  { 
  }

  public function addFixtures(Fixtures $fixture)
  { 
    if (!in_array($fixture, $this->fixtures)) {
      $this->fixtures[] = $fixture;
    }
  }

  public function executeUp()
  { 
    foreach ($this->fixtures as $fixture) {
      $fixture->load($this->pdo);
    }
  }

  public function executeDown()
  { 
    foreach ($this->fixtures as $fixture) {
      $fixture->purge($this->pdo);
    }
  }
}