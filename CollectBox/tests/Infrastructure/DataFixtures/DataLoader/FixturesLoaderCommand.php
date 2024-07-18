<?php

declare(strict_types=1);

namespace Tests\Infrastructure\DataFixtures\DataLoader;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FixturesLoaderCommand extends Command
{
  public function __construct(private FixturesLoader $fixturesLoader) 
  {
    parent::__construct();
  }

  protected function configure(): void
  {
    parent::configure();

    $this->setName('load-fixtures');
    $this->setDescription('Load all fixtures');
  }
  
  protected function execute(InputInterface $input, OutputInterface $output): int
  {
    $fixtures = $this->getFixtures();
    $count = 0;
    $output->writeln(sprintf('<info>Loading %s fixtures</info>', count($fixtures)));
    
    foreach ($fixtures as $fixture) {
      $count++;
      $this->fixturesLoader->addFixtures($fixture);
      $output->writeln(sprintf('<info>  - Fixture %s loaded successfully</info>', $count));
    }
    $output->writeln(sprintf('<info>Fixture loaded</info>'));

    $this->fixturesLoader->executeDown();
    $output->writeln(sprintf('<info>Purging database</info>'));
    $this->fixturesLoader->executeUp();
    $output->writeln(sprintf('<info>Loading database</info>'));

    $output->writeln(sprintf('<info>Fixtures correctly loaded</info>'));
    return 0;
  }

  private function getFixtures(): array 
  {
    return [
      new CollectibleFixtures()
    ];
  }
}