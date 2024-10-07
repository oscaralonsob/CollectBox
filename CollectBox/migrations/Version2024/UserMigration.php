<?php

declare(strict_types=1);

namespace Migrations\Version2024;

use Migrations\BaseMigration;

class UserMigration extends BaseMigration
{
  public function up(): void 
  {
    $this->executeSql(
      "CREATE TABLE IF NOT exists user_account (
        id VARCHAR(64) unique not null,
        user_name VARCHAR(64) not null,
        password VARCHAR(64) not null
      );"
    );
  }

  public function down(): void 
  {
    $this->executeSql(
      "DROP TABLE IF EXISTS user_account;"
    );
  }
}