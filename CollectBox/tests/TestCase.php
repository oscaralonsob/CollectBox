<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase as PHPUnit_TestCase;

class TestCase extends PHPUnit_TestCase
{
  public function __construct()
  {
    require __DIR__ . '/../vendor/autoload.php';
    $dependencies = require_once __DIR__ . "/../config/Dependencies.php";

    $builder = new \DI\ContainerBuilder();
    $dependencies($builder);
    $container = $builder->build();

    $app = \DI\Bridge\Slim\Bridge::create($container);
    $app->run();
  }
}