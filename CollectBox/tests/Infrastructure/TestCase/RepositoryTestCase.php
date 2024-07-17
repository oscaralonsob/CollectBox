<?php

declare(strict_types=1);

namespace Tests\Infrastructure\TestCase;

use PDO;
use Tests\Infrastructure\DataFixtures\DataLoader\CollectibleFixtures;

abstract class RepositoryTestCase extends BaseTestCase
{
  protected function setUp(): void
  {
    $this->truncateDatabase();
    $this->initDatabase();
  }

  private function truncateDatabase(): void 
  {
    $pdo = $this->getApplication()->getContainer()->get(PDO::class);
    $loader = new CollectibleFixtures();
    $loader->purge($pdo);
  }

  private function initDatabase(): void 
  {
    $pdo = $this->getApplication()->getContainer()->get(PDO::class);
    $loader = new CollectibleFixtures();
    $loader->load($pdo);
  }

  public abstract function repositoryClassName(): string;

  public function repository()
  {
    return $this->getApplication()->getContainer()->get($this->repositoryClassName());
  }
}