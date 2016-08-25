<?php

namespace Collections;

class InvalidArgumentException extends ArgumentException
{
    /**
     * InvalidArgumentException constructor.
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($message, $code = 102, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
