<?php

declare(strict_types=1);

use App\Collectible\Domain\Repository\CollectibleRepository;
use App\Collectible\Infrastructure\Persistance\InMemory\CollectibleInMemoryRepository;
use DI\ContainerBuilder;

return static function (ContainerBuilder $builder) {
  // Repositories
  $builder->addDefinitions([
    CollectibleRepository::class => \DI\autowire(CollectibleInMemoryRepository::class)
  ]);
};