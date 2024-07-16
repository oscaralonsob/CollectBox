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

    $this->setName('example');
    $this->setDescription('A sample command');
  }
  
  protected function execute(InputInterface $input, OutputInterface $output): int
  {
    $output->writeln(sprintf('<info>Hello, World!</info>'));

    return 0;
  }
}