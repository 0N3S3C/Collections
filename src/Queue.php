<?php

namespace Collections;

use Collections\Exceptions\ArgumentNotNumericException;
use Collections\Exceptions\ArgumentOutOfRangeException;

class Queue implements CollectionInterface, \Serializable, \JsonSerializable
{
    use EnumerableExtensions;
    
    private $subject = [];

    /**
     * Queue constructor.
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
     * @return mixed
     * @throws \UnderflowException
     */
    public function dequeue()
    {
        if (!count($this->subject)) {
            throw new \UnderflowException('Inner array is empty');
        }
        return array_splice($this->subject, 0, 1)[0];
    }

    /**
     * @param $object
     */
    public function enqueue($object)
    {
        $this->subject[] = $object;
    }

    /**
     * @return \Iterator
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
     */
    public function peek()
    {
        if (!count($this->subject)) {
            throw new \UnderflowException('Inner array is empty');
        }
        return $this->subject[0];
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
