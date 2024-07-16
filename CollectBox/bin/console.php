<?php

use Symfony\Component\Console\Application;

require __DIR__.'./../vendor/autoload.php';

$commands = require_once __DIR__ . "/../config/Commands.php";

$application = new Application();

try {
    $commands($application);
    
    $application->run();
} catch (Throwable $exception) {
    echo $exception->getMessage();
    exit(1);
}

