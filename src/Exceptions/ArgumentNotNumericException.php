<?php

namespace Collections\Exceptions;

class ArgumentNotNumericException extends \InvalidArgumentException
{
    /**
     * ArgumentNotNumericException constructor.
     * @param string $argument
     * @param string $value
     */
    public function __construct($argument, $value)
    {
        parent::__construct($argument . ' must be numeric. Got: \'' . $value . '\'');
    }
}