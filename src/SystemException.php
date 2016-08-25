<?php

namespace Collections;

class SystemException extends \Exception
{
    /**
     * SystemException constructor.
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($message, $code = 100, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
