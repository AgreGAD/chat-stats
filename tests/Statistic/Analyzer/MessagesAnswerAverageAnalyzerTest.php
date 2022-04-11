<?php

namespace ChatStats\Tests\Statistic\Analyzer;

use ChatStats\Statistic\Analyzer\MessagesAnswerAverageAnalyzer;
use JetBrains\PhpStorm\ArrayShape;
use PHPUnit\Framework\TestCase;

class MessagesAnswerAverageAnalyzerTest extends TestCase
{
    public function test_newAnalyzer_returnZero(): void
    {
        $analyzer = new MessagesAnswerAverageAnalyzer();

        $this->assertEquals(0, $analyzer->getResult());
    }

    /**
     * @dataProvider dataProvider_test_handleData_returnRealValue
     */
    public function test_handleData_returnRealValue(float $expectedResult, array $messages, string $description): void
    {
        $analyzer = new MessagesAnswerAverageAnalyzer();

        foreach ($messages as $message) {
            $analyzer->analyze($message);
        }

        $this->assertEquals($expectedResult, $analyzer->getResult(), $description);
    }

    public function dataProvider_test_handleData_returnRealValue(): iterable
    {
        yield [0, [], '0/0 = 0'];
        yield [0, [
            $this->makeMessageStructure(0),
        ], '1/0 = 0'];
        yield [0, [
            $this->makeMessageStructure(0),
            $this->makeMessageStructure(0),
        ], '2/0 = 0'];
        yield [1, [
            $this->makeMessageStructure(1),
        ], '1/1 = 1'];
        yield [1, [
            $this->makeMessageStructure(2),
        ], '1/1 = 1'];
        yield [1, [
            $this->makeMessageStructure(1),
            $this->makeMessageStructure(1),
            $this->makeMessageStructure(1),
            $this->makeMessageStructure(1),
        ], '4/4 = 1'];
        yield [2, [
            $this->makeMessageStructure(1),
            $this->makeMessageStructure(0),
            $this->makeMessageStructure(1),
            $this->makeMessageStructure(0),
        ], '4/2 = 2'];
        yield [1.5, [
            $this->makeMessageStructure(1),
            $this->makeMessageStructure(1),
            $this->makeMessageStructure(0),
        ], '3/2 = 1.5'];
    }

    #[ArrayShape([
        'messages' => 'array',
    ])]
    private function makeMessageStructure(int $countAnswers): array
    {
        $messages = [];

        if ($countAnswers > 0) {
            $messages = array_map(function () {
                return [
                    'messages' => [],
                ];
            }, range(1, $countAnswers));
        }

        return [
            'messages' => $messages,
        ];
    }

    public function test_noExpectedKey_returnZero(): void
    {
        $analyzer = new MessagesAnswerAverageAnalyzer();

        $result = $analyzer->analyze([]);

        $this->assertEquals(0, $result);
    }
}
