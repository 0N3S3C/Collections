<?php

namespace Collections;

use Collections\Exceptions\ArgumentNotNumericException;
use Collections\Exceptions\ArgumentOutOfRangeException;

class ArrayEnumerator implements EnumeratorInterface
{
    protected $pairs = [];
    protected $position = 0;

    /**
     * ArrayEnumerator constructor.
     * @param array $pairs
     */
    public function __construct(array $pairs)
    {
        foreach ($pairs as $key => $value) {
            $this->pairs[] = new KeyValuePair($key, $value);
        }
        $this->position = 0;
    }

    /**
     * @param $position
     * @return KeyValuePair
     */
    protected function getPair($position)
    {
        return isset($this->pairs[$position]) ? $this->pairs[$position] : null;
    }

    /**
     * @return KeyValuePair
     */
    protected function getCurrentPair()
    {
        return $this->getPair($this->position);
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return $this->getCurrentPair()->getValue();
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return $this->getCurrentPair()->getKey();
    }

    /**
     *
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     *
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * @param int $position
     * @throws ArgumentOutOfRangeException
     * @throws \InvalidArgumentException
     * @throws \OutOfRangeException
     */
    public function seek($position)
    {
        if (!is_numeric($position)) {
            throw new ArgumentNotNumericException('position', $position);
        }

        if ($position < 0 || $position >= count($this->pairs)) {
            throw new ArgumentOutOfRangeException('position', $position);
        }
        $this->position = $position;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return $this->getCurrentPair() !== null;
    }
}
