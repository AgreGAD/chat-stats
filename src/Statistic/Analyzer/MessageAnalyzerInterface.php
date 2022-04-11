<?php

namespace ChatStats\Statistic\Analyzer;

interface MessageAnalyzerInterface
{
    public function analyze(array $message): void;
}
