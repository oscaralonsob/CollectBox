<?php

declare(strict_types=1);

namespace Tests\Infrastructure\TestCase;

use Tests\Infrastructure\DataFixtures\DataLoader\FixturesLoader;

abstract class RepositoryTestCase extends BaseTestCase
{
  protected function setUp(): void
  {
    $this->fixtureLoader()->executeDown();
    $this->fixtureLoader()->executeUp();
  }

  public abstract function repositoryClassName(): string;

  public function repository()
  {
    return $this->getApplication()->getContainer()->get($this->repositoryClassName());
  }
  
  public function fixtureLoader(): FixturesLoader
  {
    return $this->getApplication()->getContainer()->get(FixturesLoader::class);
  }
}