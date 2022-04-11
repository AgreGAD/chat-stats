<?php

namespace ChatStats\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InfoCommand extends Command
{
    protected static $defaultName = 'info';

    protected function configure(): void
    {
        $this->addOption('short');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $isShort = (bool) $input->getOption('short');

        $output->writeln('');
        $output->writeln('');
        $output->writeln('<info>-----------------------------------------------------</info>');
        $output->writeln('');
        $output->writeln('<info>  Marat Fakhertdinov</info>\'s test task');
        $output->writeln('');
        $output->writeln('<comment>  Repository:</comment> https://github.com/AgreGAD/chat-stats');
        $output->writeln('');
        $output->writeln('<info>-----------------------------------------------------</info>');
        $output->writeln('');
        $output->writeln('');

        if ($isShort) {
            return Command::SUCCESS;
        }

        $output->writeln('<info>Usage:</info>');
        $output->writeln('');
        $output->writeln('');
        $output->writeln("<comment>  docker run --rm -it agregad/chat-stats</comment>\t\t\t- intro (current action)");
        $output->writeln('');
        $output->writeln('');
        $output->writeln("<comment>  docker run --rm -it agregad/chat-stats fulltest</comment>\t\t- check codestyle and run unit tests");
        $output->writeln('');
        $output->writeln('');
        $output->writeln('<comment>  docker run --rm -it --entrypoint=bin/console agregad/chat-stats calc http://195.140.147.119:8080/?case=b</comment>');
        $output->writeln('');
        $output->writeln("\t\t\t\t\t\t\t\t- calculate statistics from url");
        $output->writeln('');
        $output->writeln('');
        $output->writeln('<info>----------------------------------</info>');
        $output->writeln('');
        $output->writeln('');

        return Command::SUCCESS;
    }
}
