<?php

declare(strict_types=1);

use Migrations\MigrationCommand;
use Symfony\Component\Console\Application;

return static function (Application $application) {
  $application->add(new MigrationCommand());
};