<?php

use Symfony\Component\Console\Application;

require __DIR__.'./../vendor/autoload.php';
$dependencies = require_once __DIR__ . "/../config/Dependencies.php";
$commands = require_once __DIR__ . "/../config/Commands.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__."/..");
$dotenv->load();

$builder = new DI\ContainerBuilder();
$dependencies($builder);
$container = $builder->build();

$app = $container->get(Application::class);
$commands($app, $container);
$app->run();

