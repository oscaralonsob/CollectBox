<?php

declare(strict_types=1);

namespace Tests;

use App\Collectible\Infrastructure\Persistance\Postgresql\CollectiblePostgresqlRepository;
use PDO;
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
      $builder = new \DI\ContainerBuilder();
      $dependencies($builder);
      $container = $builder->build();
      $app = \DI\Bridge\Slim\Bridge::create($container);
      $pdo = $app->getContainer()->get(PDO::class);
      self::$collectiblePostgresqlRepository = new CollectiblePostgresqlRepository($pdo);
    }
  }
}