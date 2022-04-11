<?php

namespace ChatStats\Tests\Statistic\Validator;

use ChatStats\Statistic\Validator\MessageExceptionValidator;
use PHPUnit\Framework\TestCase;

class MessageExceptionValidatorTest extends TestCase
{
    /**
     * @dataProvider dataProvider_test_validData_noActions
     */
    public function test_validData_noActions(array $message): void
    {
        $validator = new MessageExceptionValidator();

        $this->assertTrue($validator->isValid($message));
    }

    public function dataProvider_test_validData_noActions(): iterable
    {
        yield [
            [
                'id' => 1,
                'text' => 'Hello!',
            ],
        ];
        yield [
            [
                'id' => 1,
                'text' => 'Hello!',
                'messages' => [],
            ],
        ];
        yield [
            [
                'id' => 1,
                'text' => 'Hello!',
                'messages' => [
                    [
                        'id' => 2,
                        'text' => 'Hello!',
                        'messages' => [],
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProvider_test_wrongData_throwException
     */
    public function test_wrongData_throwException(array $message): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $validator = new MessageExceptionValidator();

        $validator->isValid($message);
    }

    public function dataProvider_test_wrongData_throwException(): iterable
    {
        yield [
            [
                'id' => 1,
                'messages' => [],
            ],
        ];
        yield [
            [
                'text' => 'Hello!',
                'messages' => [],
            ],
        ];
        yield [
            [
                'invalid_data_message_format',
            ],
        ];
    }
}
