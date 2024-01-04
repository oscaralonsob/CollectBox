<?php

declare(strict_types=1);


namespace Tests\Unit\Collectible\Infrastructure\Persistance\Postgresql;

use App\Collectible\Domain\Repository\CollectibleRepository;
use App\Collectible\Infrastructure\Persistance\Postgresql\CollectiblePostgresqlRepository;
use Exception;
use PDO;
use PhpParser\Node\Expr\Cast\Bool_;
use Tests\Unit\Collectible\Domain\Aggregate\CollectibleMother;
use PHPUnit\Framework\TestCase;
use Slim\App;

class CollectiblePostgresqlRepositoryTest extends TestCase
{
  //TODO: create class as BaseTestCase or something like that
  //TODO: Initialize database values here, calling the parent
  private static CollectiblePostgresqlRepository $collectiblePostgresqlRepository;

  public function setUp(): void 
  {
    if (!isset(self::$collectiblePostgresqlRepository)) {
      require __DIR__ . '/../../../../../../vendor/autoload.php';
      $dependencies = require_once __DIR__ . "/../../../../../../config/Dependencies.php";
      $builder = new \DI\ContainerBuilder();
      $dependencies($builder);
      $container = $builder->build();
      $app = \DI\Bridge\Slim\Bridge::create($container);
      $pdo = $app->getContainer()->get(PDO::class);
      self::$collectiblePostgresqlRepository = new CollectiblePostgresqlRepository($pdo);
    }

    $collectible = CollectibleMother::create();
    self::$collectiblePostgresqlRepository->save($collectible);
  }

  public function testSaveInsert(): void 
  {
    $collectible = CollectibleMother::createRandom();

    self::$collectiblePostgresqlRepository->save($collectible);

    $this->assertSame($collectible->toArray(), self::$collectiblePostgresqlRepository->findById($collectible->id())->toArray());
  }

  public function testSaveUpdateWhenDoesExist(): void 
  {
    $collectible = CollectibleMother::create();

    self::$collectiblePostgresqlRepository->save($collectible);

    $this->assertSame($collectible->toArray(), self::$collectiblePostgresqlRepository->findById($collectible->id())->toArray());
  }

  public function testDeleteWhenDoesExist(): void 
  {
    $preDeleteCount = count(self::$collectiblePostgresqlRepository->findAll());
    $collectible = CollectibleMother::create();
    self::$collectiblePostgresqlRepository->delete($collectible->id());

    $this->assertCount($preDeleteCount - 1, self::$collectiblePostgresqlRepository->findAll());
  }

  public function testDeleteWhenDoesNotExist(): void 
  {
    $preDeleteCount = count(self::$collectiblePostgresqlRepository->findAll());
    $collectible = CollectibleMother::createRandom();
    self::$collectiblePostgresqlRepository->delete($collectible->id());

    $this->assertCount($preDeleteCount, self::$collectiblePostgresqlRepository->findAll());
  }

  public function testFindByIdWhenDoesExist(): void 
  {
    $collectible = CollectibleMother::create();
    $this->assertEquals($collectible->toArray(), self::$collectiblePostgresqlRepository->findById($collectible->id())->toArray());
  }

  public function testFindByIdWhenDoesNotExist(): void 
  {
    $collectible = CollectibleMother::createRandom();
    $this->assertNull(self::$collectiblePostgresqlRepository->findById($collectible->id()));
  }
} 