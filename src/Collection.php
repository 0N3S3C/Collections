<?php

namespace Collections;

use Collections\Exceptions\ArgumentNotNumericException;
use Collections\Exceptions\ArgumentOutOfRangeException;

class Collection implements SeriesInterface, \Serializable, \JsonSerializable
{
    use EnumerableExtensions;
    
    protected $subject = [];

    /**
     * Collection constructor.
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
     * @param $object
     * @return void
     */
    public function add($object)
    {
        $this->subject[] = $object;
    }

    /**
     * @param \Traversable $traversable
     * @return void
     */
    public function addRange(\Traversable $traversable)
    {
        foreach ($traversable as $object) {
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
        $this->subject = [];
    }

    /**
     * @param $object
     * @return bool
     */
    public function contains($object)
    {
        return in_array($object, $this->subject);
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
     * @param callable $predicate
     * @return bool
     */
    public function exists(callable $predicate)
    {
        $result = false;
        $count = count($this->subject);

        for ($i = 0; $i < $count; $i++) {

            if (call_user_func($predicate, $this->subject[$i])) {
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
        $count = count($this->subject);

        for ($i = 0; $i < $count; $i++) {

            if (call_user_func($predicate, $this->subject[$i])) {
                $result = $this->subject[$i];
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
        $count = count($this->subject);

        for ($i = 0; $i < $count; $i++) {

            if (call_user_func($predicate, $this->subject[$i])) {
                $results[] = $this->subject[$i];
            }
        }

        return new Collection($results);
    }

    /**
     * @return ArrayEnumerator
     */
    public function getIterator()
    {
        return new ArrayEnumerator($this->subject);
    }

    /**
     * @param $object
     * @return int
     */
    public function indexOf($object)
    {
        $index = -1;

        for ($i = 0; $i < count($this->subject); $i++) {

            if ($this->subject[$i] == $object) {
                $index = $i;
                break;
            }
        }

        return $index;
    }

    /**
     * @param $index
     * @param $object
     * @throws \InvalidArgumentException
     * @throws \OutOfRangeException
     * @return void
     */
    public function insert($index, $object)
    {
        if (!is_numeric($index)) {
            throw new ArgumentNotNumericException('index', $index);
        }

        if ($index < 0 || $index > count($this->subject)) {
            throw new ArgumentOutOfRangeException('index', $index);
        }

        if ($index == count($this->subject)) {
            $this->subject[] = $object;
        }
        else {
            array_splice($this->subject, $index, 0, $object);
        }
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return json_encode($this->subject);
    }

    /**
     * @param mixed $offset
     * @throws \InvalidArgumentException
     * @return bool
     */
    public function offsetExists($offset)
    {
        if (!is_numeric($offset)) {
            throw new ArgumentNotNumericException('offset', $offset);
        }

        return isset($this->subject[$offset]);
    }

    /**
     * @param mixed $offset
     * @throws \InvalidArgumentException
     * @throws \OutOfRangeException
     * @return mixed
     */
    public function offsetGet($offset)
    {
        if (!is_numeric($offset)) {
            throw new ArgumentNotNumericException('offset', $offset);
        }

        if (!$this->offsetExists($offset)) {
            throw new ArgumentOutOfRangeException('offset', $offset);
        }

        return $this->subject[$offset];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @throws \InvalidArgumentException
     * @throws \OutOfRangeException
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (!is_numeric($offset)) {
            throw new ArgumentNotNumericException('offset', $offset);
        }

        if (!$this->offsetExists($offset)) {
            throw new ArgumentOutOfRangeException('offset', $offset);
        }
        $this->subject[$offset] = $value;
    }

    /**
     * @param mixed $offset
     * @throws \InvalidArgumentException
     * @return void
     */
    public function offsetUnset($offset)
    {
        if (!is_numeric($offset)) {
            throw new ArgumentNotNumericException('offset', $offset);
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
        $count = count($this->subject);

        for ($i = 0; $i < $count; ++$i) {

            if ($this->subject[$i] == $object) {
                unset($this->subject[$i]);
                $found = true;
            }
        }
        $this->subject = array_values($this->subject);

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
     * @param int $index
     * @throws \InvalidArgumentException
     * @throws \OutOfRangeException
     * @return void
     */
    public function removeAt($index)
    {
        if (!is_numeric($index)) {
            throw new ArgumentNotNumericException('index', $index);
        }

        if ($index < 0 || $index >= count($this->subject)) {
            throw new ArgumentOutOFRangeException('index', $index);
        }
        unset($this->subject[$index]);
        $this->subject = array_values($this->subject);
    }

    /**
     * @param int $index
     * @param int $count
     * @throws \InvalidArgumentException
     * @throws \OutOfRangeException
     * @return void
     */
    public function removeRange($index, $count)
    {
        if (!is_numeric($index)) {
            throw new ArgumentNotNumericException('index', $index);
        }

        if (!is_numeric($count)) {
            throw new ArgumentNotNumericException('count', $index);
        }

        if ($index < 0 || $index > ($this->count() - 1)) {
            throw new ArgumentOutOfRangeException('index', $index);
        }

        if ($count < 0 || $count > ($this->count() - $index)) {
            throw new \OutOfRangeException('The range provided is out of bounds');
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
        $this->subject = array_reverse($this->subject);
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return serialize($this->subject);
    }

    /**
     * @param ComparerInterface $comparer
     */
    public function sort(ComparerInterface $comparer = null)
    {
        if ($comparer == null) {
            $comparer = Comparer::create();
        }
        usort($this->subject, [$comparer, 'compare']);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->subject;
    }

    /**
     * @param string $data
     * @return void
     */
    public function unserialize($data)
    {
        $this->subject = unserialize($data);
    }
}
