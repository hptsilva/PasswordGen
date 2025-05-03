<?php

namespace PasswordGen\Commands;

use PasswordGen\Class\Password;
use PasswordGen\Exceptions\InvalidID;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeletePasswordCommand extends Command
{
    protected static string $defaultName = 'delete';

    protected function configure(): void
    {
        $this->setName('delete')->setDescription('Delete a password.')
            ->addArgument('id', InputArgument::REQUIRED, 'ID password.');
    }

    /**
     * @throws InvalidID
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $password = new Password();
        $output->writeln($password->deletePassword($input->getArgument('id')));
        return Command::SUCCESS;
    }
}