<?php

namespace PasswordGen\Commands;
use PasswordGen\Database\Migrate;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateCommands extends Command
{
    protected static string $defaultName = 'migrate';

    protected function configure(): void
    {
        $this->setName('migrate')->setDescription('Migrate database.');
    }

    /**
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $migration = new Migrate();
        echo $migration->makeMigrations();
        return Command::SUCCESS;
    }
}