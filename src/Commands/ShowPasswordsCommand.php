<?php

namespace PasswordGen\Commands;

use PasswordGen\Class\Password;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ShowPasswordsCommand extends Command
{
    protected static string $defaultName = 'show';

    protected function configure(): void
    {
        $this->setName('show')->setDescription('List all passwords stored.');
    }

    /**
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $password = new Password();
        $table = new Table($output);
        $response = $password->listPasswords();
        $table->setHeaders(['ID', 'Password', "Site"]);
        $rows = [];
        if ($response) {
            foreach ($response as $list) {
            $rows[] = [$list['id'], $list['password'], $list['site'] ];
            }
        }
        $table->setRows($rows);
        $table->render();
        return Command::SUCCESS;
    }
}