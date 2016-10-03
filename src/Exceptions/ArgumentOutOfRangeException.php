<?php

namespace Collections\Exceptions;

class ArgumentOutOfRangeException extends \OutOfRangeException
{
    public function __construct($argument, $value)
    {
        parent::__construct($argument . ' is out of range. Got: \'' . $value . '\'');
    }
}