<?php

namespace Collections;

class Enumerable implements EnumerableInterface
{
    use EnumerableExtensions;

    private $subject;

    /**
     * Enumerable constructor.
     * @param array $subject
     */
    public function __construct(array $subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return \Iterator
     */
    public function getIterator()
    {
        return new ArrayEnumerator($this->subject);
    }
}
