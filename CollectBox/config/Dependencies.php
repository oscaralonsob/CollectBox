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
      //TODO: env file or something like that, but first this to test it
      $host = "dpg-clp3h6hoh6hc73bs8ttg-a.frankfurt-postgres.render.com";
      $dbname = "app_bhuh";
      $dbUser = "collect_box_sql";
      $dbPass = "2DRqa7ocpSWXkNjhlNNtRqFZSNDLu6pk";
      $dsn = 'pgsql:host=' . $host . ';dbname=' . $dbname;
      $options = [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          PDO::ATTR_EMULATE_PREPARES => false,
      ];

      return new PDO($dsn, $dbUser, $dbPass, $options);
    },
  ]);

  // Repositories
  $builder->addDefinitions([
    CollectibleRepository::class => \DI\autowire(CollectiblePostgresqlRepository::class)
  ]);
};