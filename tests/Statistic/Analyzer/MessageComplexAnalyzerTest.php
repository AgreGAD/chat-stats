<?php

namespace ChatStats\Tests\Statistic\Analyzer;

use ChatStats\Statistic\Analyzer\MessageAnalyzerInterface;
use ChatStats\Statistic\Analyzer\MessageComplexAnalyzer;
use PHPUnit\Framework\TestCase;

class MessageComplexAnalyzerTest extends TestCase
{
    public function test_newAnalyzer_returnEmptyArray(): void
    {
        $analyzer = new MessageComplexAnalyzer([]);

        $result = $analyzer->getResult();

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    public function test_useContainedAnalyzer_returnExpectedResult(): void
    {
        $internalAnalyzer = $this
            ->getMockBuilder(MessageAnalyzerInterface::class)
            ->onlyMethods(['analyze'])
            ->addMethods(['getResult'])
            ->getMock();
        $internalAnalyzer
            ->expects($this->exactly(2))
            ->method('analyze');
        $internalAnalyzer
            ->expects($this->once())
            ->method('getResult')
            ->willReturn(132);

        $analyzer = new MessageComplexAnalyzer(['internal' => $internalAnalyzer]);

        $message = [];

        $analyzer->analyze($message);
        $analyzer->analyze($message);

        $result = $analyzer->getResult();
        $this->assertArrayHasKey('internal', $result);
        $this->assertEquals(132, $result['internal']);
    }
}
