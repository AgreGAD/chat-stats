<?php

namespace ChatStats\Statistic\Iterator;

use ChatStats\Statistic\Analyzer\MessageComplexAnalyzer;
use ChatStats\Statistic\Validator\MessageValidatorInterface;

class MessagePhpArrayRecoursiveIteratorFactory implements MessagesIteratorFactoryInterface
{
    public function createIterator(MessageComplexAnalyzer $analyzer, MessageValidatorInterface $validator): callable
    {
        return function (array $messages) use ($analyzer, $validator) {
            $iterator = new \RecursiveArrayIterator($messages);
            $recursiveIterator = new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::SELF_FIRST);

            foreach ($recursiveIterator as $key => $message) {
                if (!is_array($message) || !is_int($key)) {
                    continue;
                }
                if (!$validator->isValid($message)) {
                    continue;
                }

                $analyzer->analyze($message);
            }
        };
    }
}
