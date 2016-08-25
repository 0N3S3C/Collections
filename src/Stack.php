<?php

namespace Collections;

class Stack implements CollectionInterface, \Serializable, \JsonSerializable
{
    use EnumerableExtensions;
    
    private $objects;
    private $position = 0;

    /**
     * Stack constructor.
     * @param array|null $array
     */
    public function __construct(array $array = [])
    {
        $this->objects = $array;
        $this->position = 0;
    }

    /**
     *
     */
    public function clear()
    {
        $this->objects = [];
    }

    /**
     * @param array $array
     * @param $index
     * @throws InvalidArgumentException
     */
    public function copyTo(array &$array, $index)
    {
        if ($index < 0) {
            throw new InvalidArgumentException("Index must be a non negative number");
        }

        if (!is_numeric($index)) {
            throw new InvalidArgumentException("Index must be a number");
        }

        for ($i = 0; $i < count($this->objects); $i++) {
            $array[$index] = $this->objects[$i];
            $index++;
        }
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->objects);
    }

    /**
     * @return ArrayEnumerator
     */
    public function getIterator()
    {
        return new ArrayEnumerator($this->objects);
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return json_encode($this->objects);
    }

    /**
     * @return mixed
     * @throws InvalidOperationException
     */
    public function peek()
    {
        if (!count($this->objects)) {
            throw new InvalidOperationException("Inner array is empty");
        }
        return $this->objects[count($this->objects) - 1];
    }

    /**
     * @return mixed
     * @throws InvalidOperationException
     */
    public function pop()
    {
        if (!count($this->objects)) {
            throw new InvalidOperationException("Inner array is empty");
        }
        return array_pop($this->objects);
    }

    /**
     * @param $object
     */
    public function push($object)
    {
        $this->objects[] = $object;
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return serialize($this->objects);
    }

    /**
     * @param string $data
     */
    public function unserialize($data)
    {
        $this->objects = unserialize($data);
    }
}
