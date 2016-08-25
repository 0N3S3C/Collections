<?php

namespace Collections;

class ArgumentNullException extends ArgumentException
{
    /**
     * ArgumentNullException constructor.
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($message, $code = 101, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
