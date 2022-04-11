<?php

namespace ChatStats\Statistic;

use ChatStats\Statistic\Analyzer\MessageComplexAnalyzer;
use ChatStats\Statistic\Iterator\MessagesIteratorFactoryInterface;
use ChatStats\Statistic\Validator\MessageValidatorInterface;

class StatisticService
{
    private MessageComplexAnalyzer $analyzer;
    private MessageValidatorInterface $validator;
    private MessagesIteratorFactoryInterface $iteratorFactory;

    public function __construct(MessageComplexAnalyzer $analyzer, MessageValidatorInterface $validator, MessagesIteratorFactoryInterface $iteratorFactory)
    {
        $this->analyzer = $analyzer;
        $this->validator = $validator;
        $this->iteratorFactory = $iteratorFactory;
    }

    public function calculate(array $messages): array
    {
        $iterator = $this->iteratorFactory->createIterator($this->analyzer, $this->validator);

        $iterator($messages);

        return $this->analyzer->getResult();
    }
}
