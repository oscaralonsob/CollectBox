<?php

declare(strict_types=1);

namespace Migrations;

use PDO;
use Dotenv;
use Migrations\Version2024\InitMigration;

abstract class BaseMigration
{
  protected static PDO $pdo;

  abstract function up(): void;
  abstract function down(): void;

  protected function __construct()
  {
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

  protected function executeSql(string $sql): void 
  {
    $stmt = self::$pdo->prepare($sql);
    $stmt->execute();
  }

  public static function getMigrations(): array 
  {
    return [
      new InitMigration()
    ];
  }
}