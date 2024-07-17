<?php

declare(strict_types=1);

use DI\Container;
use Migrations\MigrationCommand;
use Symfony\Component\Console\Application;

return static function (Application $application, Container $container) {
  $application->add($container->get(MigrationCommand::class));
};