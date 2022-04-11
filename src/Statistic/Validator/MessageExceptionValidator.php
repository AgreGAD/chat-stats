<?php

namespace ChatStats\Statistic\Validator;

class MessageExceptionValidator implements MessageValidatorInterface
{
    private MessageSkippingValidator $validator;

    public function __construct()
    {
        $this->validator = new MessageSkippingValidator();
    }

    public function isValid(array $message): bool
    {
        if (!$this->validator->isValid($message)) {
            throw new \InvalidArgumentException('Invalid format of message');
        }

        return true;
    }
}
