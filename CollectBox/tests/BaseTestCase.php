<?php

declare(strict_types=1);

namespace Tests;

use PDO;
use Dotenv;
use PHPUnit\Framework\TestCase as PHPUnit_TestCase;
use Tests\Infrastructure\DataFixtures\DataLoader\CollectibleFixtures;

abstract class BaseTestCase extends PHPUnit_TestCase
{
  protected static PDO $pdo;

  protected function setUp(): void
  {
    if (!isset(self::$pdo)) {
      require __DIR__ . '/../vendor/autoload.php';
      $dependencies = require_once __DIR__ . "/../config/Dependencies.php";

      $dotenv = Dotenv\Dotenv::createImmutable(__DIR__."/..");
      $dotenv->load();

      $builder = new \DI\ContainerBuilder();
      $dependencies($builder);
      $container = $builder->build();
      $app = \DI\Bridge\Slim\Bridge::create($container);
      self::$pdo = $app->getContainer()->get(PDO::class);
    }

    $this->truncateDatabase();
    $this->initDatabase();
  }

  //TODO: migrate to purger (like fixtures)
  private function truncateDatabase(): void 
  {
    $stmt = self::$pdo->prepare("DELETE FROM collectible");
    $stmt->execute();
  }

  private function initDatabase(): void 
  {
    $loader = new CollectibleFixtures();
    $loader->load(self::$pdo);
  }
}