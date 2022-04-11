<?php

namespace ChatStats\Statistic\Analyzer;

class MessageMaxLengthAnalyzer implements MessageAnalyzerInterface
{
    private int $result = 0;

    public function analyze(array $message): void
    {
        if (!array_key_exists('text', $message)) {
            throw new \InvalidArgumentException('Required key "text" is not found');
        }

        $textLength = mb_strlen($message['text']);

        $this->result = max($textLength, $this->result);
    }

    public function getResult(): int
    {
        return $this->result;
    }
}
