<?php

namespace ChatStats\Statistic\Analyzer;

class MessageComplexAnalyzer implements MessageAnalyzerInterface
{
    private array $analyzers = [];

    public function __construct(array $analyzers = [])
    {
        foreach ($analyzers as $key => $analyzer) {
            $this->setAnalyzer($key, $analyzer);
        }
    }

    public function setAnalyzer(string $key, MessageAnalyzerInterface $analyzer): void
    {
        $this->analyzers[$key] = $analyzer;
    }

    public function analyze(array $message): void
    {
        foreach ($this->analyzers as $analyzer) {
            $analyzer->analyze($message);
        }
    }

    public function getResult(): array
    {
        $result = [];

        foreach ($this->analyzers as $key => $analyzer) {
            $result[$key] = $analyzer->getResult();
        }

        return $result;
    }
}
