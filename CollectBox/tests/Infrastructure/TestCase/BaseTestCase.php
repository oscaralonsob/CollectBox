<?php

declare(strict_types=1);

namespace Tests\Infrastructure\TestCase;

use Dotenv;
use PHPUnit\Framework\TestCase;
use Slim\App;

abstract class BaseTestCase extends TestCase
{
  private ?App $app = null;

  protected function getApplication(): App
  {
    if (!$this->app) {
      require __DIR__ . '/../../../vendor/autoload.php';
      $dependencies = require __DIR__ . "/../../../config/Dependencies.php";

      $dotenv = Dotenv\Dotenv::createImmutable(__DIR__."/../../..");
      $dotenv->load();

      $builder = new \DI\ContainerBuilder();
      $dependencies($builder);
      $container = $builder->build();
      $this->app = \DI\Bridge\Slim\Bridge::create($container);
    }

    return $this->app;
  }
}