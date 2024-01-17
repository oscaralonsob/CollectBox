<?php

declare(strict_types=1);

namespace Tests;

use App\Collectible\Infrastructure\Persistance\Postgresql\CollectiblePostgresqlRepository;
use PDO;
use Dotenv;
use PHPUnit\Framework\TestCase as PHPUnit_TestCase;
use Tests\Unit\Collectible\Domain\Aggregate\CollectibleMother;

abstract class BaseTestCase extends PHPUnit_TestCase
{
  protected static CollectiblePostgresqlRepository $collectiblePostgresqlRepository;

  protected function setUp(): void
  {
    if (!isset(self::$collectiblePostgresqlRepository)) {
      require __DIR__ . '/../vendor/autoload.php';
      $dependencies = require_once __DIR__ . "/../config/Dependencies.php";

      $dotenv = Dotenv\Dotenv::createImmutable(__DIR__."/..");
      $dotenv->load();

      $builder = new \DI\ContainerBuilder();
      $dependencies($builder);
      $container = $builder->build();
      $app = \DI\Bridge\Slim\Bridge::create($container);
      $pdo = $app->getContainer()->get(PDO::class);
      self::$collectiblePostgresqlRepository = new CollectiblePostgresqlRepository($pdo);
    }

    $this->truncateDatabase();
    $this->initDatabase();
  }

  private function truncateDatabase(): void 
  {
    foreach (self::$collectiblePostgresqlRepository->findAll() as $collectible) {
      self::$collectiblePostgresqlRepository->delete($collectible->id());
    }
  }

  private function initDatabase(): void 
  {
    $collectible = CollectibleMother::create();
    self::$collectiblePostgresqlRepository->save($collectible);
  }
}