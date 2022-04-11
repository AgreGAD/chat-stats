<?php

namespace ChatStats\Tests\Statistic\Analyzer;

use ChatStats\Statistic\Analyzer\MessageMaxLengthAnalyzer;
use JetBrains\PhpStorm\ArrayShape;
use PHPUnit\Framework\TestCase;

class MessageMaxLengthAnalyzerTest extends TestCase
{
    public function test_newAnalyzer_returnZero(): void
    {
        $analyzer = new MessageMaxLengthAnalyzer();

        $this->assertEquals(0, $analyzer->getResult());
    }

    /**
     * @dataProvider dataProvider_test_handleData_returnRealValue
     */
    public function test_handleData_returnRealValue(int $expectedResult, array $messages): void
    {
        $analyzer = new MessageMaxLengthAnalyzer();

        foreach ($messages as $message) {
            $analyzer->analyze($message);
        }

        $this->assertEquals($expectedResult, $analyzer->getResult());
    }

    public function dataProvider_test_handleData_returnRealValue(): iterable
    {
        yield [0, []];
        yield [0, [
            $this->makeMessageStructure(''),
        ]];
        yield [0, [
            $this->makeMessageStructure(''),
            $this->makeMessageStructure(''),
        ]];
        yield [3, [
            $this->makeMessageStructure('foo'),
            $this->makeMessageStructure(''),
        ]];
        yield [6, [
            $this->makeMessageStructure('foo'),
            $this->makeMessageStructure('barba6'),
        ]];
        yield [7, [
            $this->makeMessageStructure('foo'),
            $this->makeMessageStructure(''),
            $this->makeMessageStructure('barbar7'),
        ]];
    }

    #[ArrayShape([
        'text' => 'string',
    ])]
    private function makeMessageStructure(string $text): array
    {
        return [
            'text' => $text,
        ];
    }

    public function test_handleIncorrectData_throwException(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $analyzer = new MessageMaxLengthAnalyzer();

        $analyzer->analyze([]);
    }
}
