<?php

namespace ChatStats\Statistic\Validator;

interface MessageValidatorInterface
{
    public function isValid(array $message): bool;
}
