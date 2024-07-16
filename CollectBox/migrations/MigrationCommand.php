<?php

declare(strict_types=1);

namespace Migrations;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrationCommand extends Command
{
  protected function configure(): void
  {
    parent::configure();

    $this->setName('migrations');
    $this->setDescription('Execute all migrations');
  }
  
  protected function execute(InputInterface $input, OutputInterface $output): int
  {
    $migrations = BaseMigration::getMigrations();
    $count = 0;
    $output->writeln(sprintf('<info>Executing %s migrations</info>', count($migrations)));
    
    foreach ($migrations as $migration) {
      $count++;
      $migration->up();
      $output->writeln(sprintf('<info>  - Executed migration %s successfully</info>', $count));
    }

    $output->writeln(sprintf('<info>Migrations executed</info>'));
    return 0;
  }
}