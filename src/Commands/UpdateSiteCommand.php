<?php

namespace PasswordGen\Commands;

use PasswordGen\Class\Password;
use PasswordGen\Exceptions\InvalidID;
use PasswordGen\Exceptions\InvalidLength;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateSiteCommand extends Command
{
    protected static string $defaultName = 'update';

    protected function configure(): void
    {
        $this->setName('update')->setDescription('Update site.')
            ->addArgument('id', InputArgument::REQUIRED, 'ID password.')
            ->addArgument('site', InputArgument::REQUIRED, 'Site name.');
    }

    /**
     * @throws InvalidID
     * @throws InvalidLength
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $password = new Password();
        $output->writeln($password->updateSite($input->getArgument('id'), $input->getArgument('site')));
        return Command::SUCCESS;
    }
}