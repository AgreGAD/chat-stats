<?php

namespace ChatStats\Tests\Statistic;

use ChatStats\Statistic\Analyzer\MessageComplexAnalyzer;
use ChatStats\Statistic\Analyzer\MessageMaxLengthAnalyzer;
use ChatStats\Statistic\Analyzer\MessagesAnswerAverageAnalyzer;
use ChatStats\Statistic\Iterator\MessageAnonymousFunctionIteratorFactory;
use ChatStats\Statistic\Iterator\MessagePhpArrayRecoursiveIteratorFactory;
use ChatStats\Statistic\StatisticService;
use ChatStats\Statistic\Validator\MessageSkippingValidator;
use ChatStats\Statistic\Validator\MessageValidatorInterface;
use PHPUnit\Framework\TestCase;

class IntegrationTest extends TestCase
{
    /**
     * @dataProvider dataProvider_calculate
     */
    public function testStatisticService_phpArrayRecoursiveIterator_returnExpectedResults(array $messages, array $expectedResult): void
    {
        $iteratorFactory = new MessagePhpArrayRecoursiveIteratorFactory();
        $statsService = new StatisticService($this->createAnalyzer(), $this->createValidator(), $iteratorFactory);

        $this->assertEquals($expectedResult, $statsService->calculate($messages));
    }

    /**
     * @dataProvider dataProvider_calculate
     */
    public function testStatisticService_anonymousFunctionIterator_returnExpectedResults(array $messages, array $expectedResult): void
    {
        $iteratorFactory = new MessageAnonymousFunctionIteratorFactory();
        $statsService = new StatisticService($this->createAnalyzer(), $this->createValidator(), $iteratorFactory);

        $this->assertEquals($expectedResult, $statsService->calculate($messages));
    }

    public function dataProvider_calculate(): iterable
    {
        yield [
            'messages' => [],
            'expected' => [
                'avg_answers' => 0,
                'max_length' => 0,
            ],
        ];

        yield [
            'messages' => [
                [
                    'id' => 1,
                    'text' => "Hello!\n",
                    'messages' => [
                        [
                            'id' => 2,
                            'text' => "Hi!\n",
                        ],
                        [
                            'id' => 3,
                            'text' => "Hi man!\n",
                        ],
                        [
                            'id' => 4,
                            'text' => "How are you?\n",
                            'messages' => [
                                [
                                    'id' => 5,
                                    'text' => "Fine Thanks! How are you?\n",
                                ],
                                [
                                    'id' => 6,
                                    'text' => "Good!\n",
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'id' => 7,
                    'text' => "What's ypur name?\n",
                    'messages' => [
                        [
                            'id' => 8,
                            'text' => "My name is Mikhail.\n",
                        ],
                        [
                            'id' => 9,
                            'text' => "I'm a batman!\n",
                        ],
                    ],
                ],
            ],
            'expected' => [
                'avg_answers' => 3,
                'max_length' => 26,
            ],
        ];
    }

    public function testStatisticService_invalidDataWithSkippingValidator_returnExpectedResults(): void
    {
        $messages = [
            [
                'id' => 7,
                'text' => "What's ypur name?\n",
                'messages' => [
                    [
                        'id' => 8,
                        'text' => "My name is Mikhail.\n",
                    ],
                ],
            ],
            [
                'invalid_data_message_format',
            ],
        ];

        $iteratorFactory = new MessagePhpArrayRecoursiveIteratorFactory();
        $statsService = new StatisticService($this->createAnalyzer(), $this->createValidator(), $iteratorFactory);

        $result = $statsService->calculate($messages);
        $this->assertEquals(2, $result['avg_answers']);
        $this->assertEquals(20, $result['max_length']);
    }

    private function createValidator(): MessageValidatorInterface
    {
        return new MessageSkippingValidator();
    }

    private function createAnalyzer(): MessageComplexAnalyzer
    {
        $analyzer = new MessageComplexAnalyzer();

        $analyzer->setAnalyzer('avg_answers', new MessagesAnswerAverageAnalyzer());
        $analyzer->setAnalyzer('max_length', new MessageMaxLengthAnalyzer());

        return $analyzer;
    }
}
