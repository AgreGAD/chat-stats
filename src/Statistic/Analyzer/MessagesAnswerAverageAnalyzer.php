<?php

namespace ChatStats\Statistic\Analyzer;

class MessagesAnswerAverageAnalyzer implements MessageAnalyzerInterface
{
    private int $countOfMessages = 0;
    private int $countOfTalkings = 0;

    public function analyze(array $message): void
    {
        ++$this->countOfMessages;

        if (!empty($message['messages'])) {
            ++$this->countOfTalkings;
        }
    }

    public function getResult(): float
    {
        if (0 === $this->countOfTalkings) {
            return 0;
        }

        return $this->countOfMessages / $this->countOfTalkings;
    }
}
