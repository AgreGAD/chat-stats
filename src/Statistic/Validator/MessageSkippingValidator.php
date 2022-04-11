<?php

namespace ChatStats\Statistic\Validator;

class MessageSkippingValidator implements MessageValidatorInterface
{
    private const REQUIRED_KEYS = ['id', 'text'];

    public function isValid(array $message): bool
    {
        $notExistingKeys = array_diff(self::REQUIRED_KEYS, array_keys($message));

        return empty($notExistingKeys);
    }
}
