<?php

namespace ChatStats\Statistic\Iterator;

use ChatStats\Statistic\Analyzer\MessageComplexAnalyzer;
use ChatStats\Statistic\Validator\MessageValidatorInterface;

interface MessagesIteratorFactoryInterface
{
    public function createIterator(MessageComplexAnalyzer $analyzer, MessageValidatorInterface $validator): callable;
}
