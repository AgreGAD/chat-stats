<?php

namespace ChatStats\Tests\Statistic\Validator;

use ChatStats\Statistic\Validator\MessageSkippingValidator;
use PHPUnit\Framework\TestCase;

class MessageSkippingValidatorTest extends TestCase
{
    /**
     * @dataProvider dataProvider_test_validData_noActions
     */
    public function test_validData_noActions(array $message): void
    {
        $validator = new MessageSkippingValidator();

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
        $validator = new MessageSkippingValidator();

        $this->assertFalse($validator->isValid($message));
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
