<?php

namespace Collections;

class ArgumentException extends SystemException
{
    /**
     * ArgumentException constructor.
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($message, $code = 100, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
