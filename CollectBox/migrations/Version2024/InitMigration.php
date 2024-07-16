<?php

declare(strict_types=1);

namespace Migrations\Version2024;

use Migrations\BaseMigration;

class InitMigration extends BaseMigration
{
  public function up(): void 
  {
    $this->executeSql(
      "CREATE TABLE IF NOT exists collectible (
        id VARCHAR(64) unique not null,
        code VARCHAR(64) not null,
        name VARCHAR(64) not null,
        url VARCHAR(64) not null
      );"
    );
  }

  public function down(): void 
  {
    $this->executeSql(
      "DROP TABLE IF EXISTS  collectible;"
    );
  }
}