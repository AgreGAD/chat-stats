<?php

namespace ChatStats\Statistic\Iterator;

use ChatStats\Statistic\Analyzer\MessageComplexAnalyzer;
use ChatStats\Statistic\Validator\MessageValidatorInterface;

class MessageAnonymousFunctionIteratorFactory implements MessagesIteratorFactoryInterface
{
    public function createIterator(MessageComplexAnalyzer $analyzer, MessageValidatorInterface $validator): callable
    {
        return $iterator = function (array $messages) use (&$iterator, $analyzer, $validator) {
            foreach ($messages as $message) {
                if (!$validator->isValid($message)) {
                    continue;
                }

                $analyzer->analyze($message);

                if (!empty($message['messages'])) {
                    $iterator($message['messages']);
                }
            }
        };
    }
}
