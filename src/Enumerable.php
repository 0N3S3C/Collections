<?php

namespace Collections;

class Enumerable implements EnumerableInterface
{
    use EnumerableExtensions;

    private $subject = [];

    /**
     * Enumerable constructor.
     * @param array $subject
     */
    public function __construct(array $subject)
    {
        $counter = 0;

        foreach ($subject as $item) {
            $this->subject[$counter] = $item;
            $counter++;
        }
    }

    /**
     * @return \Iterator
     */
    public function getIterator()
    {
        return new ArrayEnumerator($this->subject);
    }
}
