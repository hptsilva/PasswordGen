<?php

namespace PasswordGen\Commands;

use PasswordGen\Exceptions\InvalidLength;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use PasswordGen\Class\Password;
use Random\RandomException;

class GeneratePasswordCommand extends Command
{
    protected static string $defaultName = 'generate';

    protected function configure(): void
    {
        $this->setName('generate')->setDescription('Generate a password for your site')
            ->addArgument('length', InputArgument::REQUIRED, 'Length of password.')
            ->addArgument('site', InputArgument::REQUIRED, 'Site name.');
    }

    /**
     * @throws InvalidLength
     * @throws RandomException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $password = new Password();
        $output->writeln($password->generate($input->getArgument('length'), $input->getArgument('site')));
        return Command::SUCCESS;
    }
}