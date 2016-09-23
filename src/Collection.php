<?php

namespace Collections;

class Collection implements SeriesInterface, \Serializable, \JsonSerializable
{
    use EnumerableExtensions;
    
    protected $objects;

    /**
     * Collection constructor.
     * @param array $array
     */
    public function __construct(array $array = [])
    {
        $this->objects = $array;
    }

    /**
     * @param $object
     * @return void
     */
    public function add($object)
    {
        $this->objects[] = $object;
    }

    /**
     * @param EnumerableInterface $enumerable
     * @return void
     */
    public function addRange(EnumerableInterface $enumerable)
    {
        foreach ($enumerable as $object) {
            $this->add($object);
        }
    }

    /**
     * @return ReadOnlyCollection
     */
    public function asReadOnly()
    {
        return new ReadOnlyCollection($this);
    }

    /**
     * @return void
     */
    public function clear()
    {
        $this->objects = [];
    }

    /**
     * @param $object
     * @return bool
     */
    public function contains($object)
    {
        return in_array($object, $this->objects);
    }

    /**
     * @param array $array
     * @param $index
     * @throws InvalidArgumentException
     */
    public function copyTo(array &$array, $index = 0)
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
     * @param callable $predicate
     * @return bool
     */
    public function exists(callable $predicate)
    {
        $result = false;
        $count = count($this->objects);

        for ($i = 0; $i < $count; $i++) {

            if (call_user_func($predicate, $this->objects[$i])) {
                $result = true;
                break;
            }
        }

        return $result;
    }

    /**
     * @param callable $predicate
     * @return mixed|null
     */
    public function find(callable $predicate)
    {
        $result = null;
        $count = count($this->objects);

        for ($i = 0; $i < $count; $i++) {

            if (call_user_func($predicate, $this->objects[$i])) {
                $result = $this->objects[$i];
                break;
            }
        }

        return $result;
    }

    /**
     * @param callable $predicate
     * @return Collection
     */
    public function findAll(callable $predicate)
    {
        $results = [];
        $count = count($this->objects);

        for ($i = 0; $i < $count; $i++) {

            if (call_user_func($predicate, $this->objects[$i])) {
                $results[] = $this->objects[$i];
            }
        }

        return new Collection($results);
    }

    /**
     * @return ArrayEnumerator
     */
    public function getIterator()
    {
        return new ArrayEnumerator($this->objects);
    }

    /**
     * @param $object
     * @return int
     */
    public function indexOf($object)
    {
        $index = -1;

        for ($i = 0; $i < count($this->objects); $i++) {

            if ($this->objects[$i] == $object) {
                $index = $i;
                break;
            }
        }

        return $index;
    }

    /**
     * @param $index
     * @param $object
     * @throws InvalidArgumentException
     * @throws ArgumentOutOfRangeException
     * @return void
     */
    public function insert($index, $object)
    {
        if (!is_numeric($index)) {
            throw new InvalidArgumentException("Index must be numeric");
        }

        if ($index < 0 || $index > count($this->objects)) {
            throw new ArgumentOutOfRangeException("Invalid index ({$index})");
        }

        if ($index == count($this->objects)) {
            $this->objects[] = $object;
        }
        else {
            array_splice($this->objects, $index, 0, $object);
        }
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return json_encode($this->objects);
    }

    /**
     * @param mixed $offset
     * @throws InvalidArgumentException
     * @return bool
     */
    public function offsetExists($offset)
    {
        if (!is_numeric($offset)) {
            throw new InvalidArgumentException("Index must be numeric");
        }

        return isset($this->objects[$offset]);
    }

    /**
     * @param mixed $offset
     * @throws InvalidArgumentException
     * @throws ArgumentOutOfRangeException
     * @return mixed
     */
    public function offsetGet($offset)
    {
        if (!is_numeric($offset)) {
            throw new InvalidArgumentException("Index must be numeric");
        }

        if (!$this->offsetExists($offset)) {
            throw new ArgumentOutOfRangeException("Invalid index ({$offset})");
        }

        return $this->objects[$offset];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @throws InvalidArgumentException
     * @throws ArgumentOutOfRangeException
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (!is_numeric($offset)) {
            throw new InvalidArgumentException("Index must be numeric");
        }

        if (!$this->offsetExists($offset)) {
            throw new ArgumentOutOfRangeException("Invalid index ({$offset})");
        }
        $this->objects[$offset] = $value;
    }

    /**
     * @param mixed $offset
     * @throws InvalidArgumentException
     * @return void
     */
    public function offsetUnset($offset)
    {
        if (!is_numeric($offset)) {
            throw new InvalidArgumentException("Index must be numeric");
        }
        $this->removeAt($offset);
    }

    /**
     * @param $object
     * @return bool
     */
    public function remove($object)
    {
        $found = false;
        $count = count($this->objects);

        for ($i = 0; $i < $count; ++$i) {

            if ($this->objects[$i] == $object) {
                unset($this->objects[$i]);
                $found = true;
            }
        }
        $this->objects = array_values($this->objects);

        return $found;
    }

    /**
     * @param callable $predicate
     * @return void
     */
    public function removeAll(callable $predicate)
    {
        for ($i = $this->count() - 1; $i >= 0; $i--) {

            if (call_user_func($predicate, $this[$i])) {
                $this->removeAt($i);
            }
        }
    }

    /**
     * @param $index
     * @throws InvalidArgumentException
     * @throws ArgumentException
     * @throws ArgumentOutOfRangeException
     * @return void
     */
    public function removeAt($index)
    {
        if (!is_numeric($index)) {
            throw new InvalidArgumentException("Index must be numeric");
        }

        if ($index < 0) {
            throw new ArgumentOutOfRangeException("Index is out of range ({$index})");
        }

        if ($index < 0 || $index >= count($this->objects)) {
            throw new ArgumentOutOfRangeException("Invalid index ({$index})");
        }
        unset($this->objects[$index]);
        $this->objects = array_values($this->objects);
    }

    /**
     * @param $index
     * @param $count
     * @throws ArgumentException
     * @throws ArgumentOutOfRangeException
     * @return void
     */
    public function removeRange($index, $count)
    {
        if ($index < 0) {
            throw new ArgumentOutOfRangeException("Index is not valid ({$index})");
        }

        if ($count < 0) {
            throw new ArgumentOutOfRangeException("Count is not valid ({$count})");
        }

        if ($index + $count > $this->count()) {
            throw new InvalidArgumentException("The range provided is not valid");
        }

        for ($i = $index; $count > 0; $count--) {
            $this->removeAt($i);
        }
    }

    /**
     * @return void
     */
    public function reverse()
    {
        $this->objects = array_reverse($this->objects);
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return serialize($this->objects);
    }

    /**
     * @param ComparerInterface $comparer
     */
    public function sort(ComparerInterface $comparer = null)
    {
        if ($comparer == null) {
            $comparer = Comparer::create();
        }
        usort($this->objects, [$comparer, 'compare']);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->objects;
    }

    /**
     * @param string $data
     * @return void
     */
    public function unserialize($data)
    {
        $this->objects = unserialize($data);
    }
}
