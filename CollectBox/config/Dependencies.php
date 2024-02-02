<?php

declare(strict_types=1);

use App\Collectible\Domain\Repository\CollectibleRepository;
use App\Collectible\Infrastructure\Persistance\InMemory\CollectibleInMemoryRepository;
use App\Collectible\Infrastructure\Persistance\Postgresql\CollectiblePostgresqlRepository;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

return static function (ContainerBuilder $builder) {
  // Database connection
  $builder->addDefinitions([
    PDO::class => function (ContainerInterface $container) {
      $dsn = 'pgsql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'];
      $options = [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          PDO::ATTR_EMULATE_PREPARES => false,
      ];

      return new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS'], $options);
    },
  ]);

  // Repositories
  $builder->addDefinitions([
    CollectibleRepository::class => \DI\autowire(CollectiblePostgresqlRepository::class)
  ]);
};