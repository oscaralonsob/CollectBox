<?php

declare(strict_types=1);

namespace Migrations;

use PDO;
use Migrations\Version2024\InitMigration;

abstract class BaseMigration
{
  protected static PDO $pdo;

  abstract function up(): void;
  abstract function down(): void;

  public function __construct(PDO $pdo)
  {
    self::$pdo = $pdo;
  }

  protected function executeSql(string $sql): void 
  {
    $stmt = self::$pdo->prepare($sql);
    $stmt->execute();
  }
}