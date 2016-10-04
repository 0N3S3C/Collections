<?php

namespace Collections;

use Collections\Exceptions\ArgumentNotNumericException;
use Collections\Exceptions\ArgumentOutOfRangeException;

class Stack implements CollectionInterface, \Serializable, \JsonSerializable
{
    use EnumerableExtensions;
    
    private $subject = [];

    /**
     * Stack constructor.
     * @param array $subject
     */
    public function __construct(array $subject = [])
    {
        $counter = 0;

        foreach ($subject as $item) {
            $this->subject[$counter] = $item;
            $counter++;
        }
    }

    /**
     *
     */
    public function clear()
    {
        $this->subject = [];
    }

    /**
     * @param array $array
     * @param $index
     * @throws \InvalidArgumentException
     * @throws \OutOfRangeException
     */
    public function copyTo(array &$array, $index = 0)
    {
        if ($index < 0) {
            throw new ArgumentOutOfRangeException('index', $index);
        }

        if (!is_numeric($index)) {
            throw new ArgumentNotNumericException('index', $index);
        }

        for ($i = 0; $i < count($this->subject); $i++) {
            $array[$index] = $this->subject[$i];
            $index++;
        }
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->subject);
    }

    /**
     * @return ArrayEnumerator
     */
    public function getIterator()
    {
        return new ArrayEnumerator($this->subject);
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return json_encode($this->subject);
    }

    /**
     * @return mixed
     * @throws \UnderflowException
     */
    public function peek()
    {
        if (!count($this->subject)) {
            throw new \UnderflowException('Inner array is empty');
        }
        return $this->subject[count($this->subject) - 1];
    }

    /**
     * @return mixed
     * @throws \UnderflowException
     */
    public function pop()
    {
        if (!count($this->subject)) {
            throw new \UnderflowException('Inner array is empty');
        }
        return array_pop($this->subject);
    }

    /**
     * @param $object
     */
    public function push($object)
    {
        $this->subject[] = $object;
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return serialize($this->subject);
    }

    /**
     * @param string $data
     */
    public function unserialize($data)
    {
        $this->subject = unserialize($data);
    }
}
