<?php

namespace ChatStats\Console;

use ChatStats\Statistic\Analyzer\MessageComplexAnalyzer;
use ChatStats\Statistic\Analyzer\MessageMaxLengthAnalyzer;
use ChatStats\Statistic\Analyzer\MessagesAnswerAverageAnalyzer;
use ChatStats\Statistic\Iterator\MessagePhpArrayRecoursiveIteratorFactory;
use ChatStats\Statistic\StatisticService;
use ChatStats\Statistic\Validator\MessageSkippingValidator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CalcStatisticCommand extends Command
{
    protected static $defaultName = 'calc';

    protected function configure(): void
    {
        $this->addArgument('source', InputArgument::REQUIRED, '');
        $this->addArgument('key', InputArgument::OPTIONAL, '', 'data');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $source = $input->getArgument('source');
        $key = $input->getArgument('key');

        try {
            $content = file_get_contents($source);
        } catch (\Throwable $e) {
            throw new \InvalidArgumentException($e->getMessage());
        }

        $inputData = json_decode($content, true);

        if (!is_array($inputData)) {
            throw new \InvalidArgumentException('Incorrect input data. Expected: json');
        }

        if (!empty($key) && !array_key_exists($key, $inputData)) {
            throw new \InvalidArgumentException('Incorrect key in JSON data: ' . $key);
        }

        $messages = !empty($key) ? $inputData[$key] : $inputData;

        $output->writeln('<info>Inputs</info>');
        $output->writeln("<comment>Source:</comment> $source");
        $output->writeln('<comment>Messages:</comment>');
        $output->writeln(json_encode($messages, JSON_PRETTY_PRINT));
        $output->writeln('');

        $results = $this->crateStatisticService()->calculate($messages);

        $output->writeln('<info>Results</info>');
        foreach ($results as $key => $value) {
            $output->writeln("<comment>$key:</comment> $value");
        }
        $output->writeln('');
        $output->writeln('');

        return Command::SUCCESS;
    }

    private function crateStatisticService(): StatisticService
    {
        $analyzer = new MessageComplexAnalyzer();
        $analyzer->setAnalyzer('avg_answers', new MessagesAnswerAverageAnalyzer());
        $analyzer->setAnalyzer('max_length', new MessageMaxLengthAnalyzer());

        $validator = new MessageSkippingValidator();
        $iteratorFactory = new MessagePhpArrayRecoursiveIteratorFactory();

        return new StatisticService($analyzer, $validator, $iteratorFactory);
    }
}
