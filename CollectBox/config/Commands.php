<?php

declare(strict_types=1);

use DI\Container;
use Migrations\MigrationCommand;
use Symfony\Component\Console\Application;
use Tests\Infrastructure\DataFixtures\DataLoader\FixturesLoaderCommand;

return static function (Application $application, Container $container) {
  $application->add($container->get(MigrationCommand::class));
  $application->add($container->get(FixturesLoaderCommand::class));
};