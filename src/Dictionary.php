<?php

namespace Collections;

use Collections\Exceptions\ArgumentNotNumericException;
use Collections\Exceptions\ArgumentOutOfRangeException;

class Dictionary implements DictionaryInterface, \Serializable, \JsonSerializable
{
    use EnumerableExtensions;
    
    protected $keys;
    protected $values;

    /**
     * Dictionary constructor.
     * @param array|null $array
     */
    public function __construct(array $array = [])
    {
        $this->keys = new Collection();
        $this->values = new Collection();

        foreach ($array as $key => $value) {
            $this->keys->add($key);
            $this->values->add($value);
        }
    }

    /**
     * @param $key
     * @param $value
     * @throws \OverflowException
     */
    public function add($key, $value)
    {
        if ($this->containsKey($key)) {
            throw new \OverflowException('Key already exists');
        }
        $this->keys->add($key);
        $this->values->add($value);
    }

    /**
     *
     */
    public function clear()
    {
        $this->keys->clear();
        $this->values->clear();
    }

    /**
     * @param $key
     * @return bool
     */
    public function contains($key)
    {
        return $this->keys->contains($key);
    }

    /**
     * @param $key
     * @return bool
     */
    public function containsKey($key)
    {
        return $this->keys->contains($key);
    }

    /**
     * @param $value
     * @return bool
     */
    public function containsValue($value)
    {
        return $this->values->contains($value);
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

        for ($i = 0; $i < count($this->keys); $i++) {
            $array[$index] = new KeyValuePair($this->keys[$i], $this->values[$i]);
            $index++;
        }
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->keys);
    }

    public function getIterator()
    {
        $output = [];
        $count = $this->keys->count();

        for ($i = 0; $i < $count; $i++) {
            $output[$this->keys[$i]] = $this->values[$i];
        }

        return new ArrayEnumerator($output);
    }

    /**
     * @return ReadOnlyCollection
     */
    public function getKeys()
    {
        return $this->keys->asReadOnly();
    }

    /**
     * @return ReadOnlyCollection
     */
    public function getValues()
    {
        return $this->values->asReadOnly();
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        $output = [];
        $count = $this->keys->count();

        for ($i = 0; $i < $count; $i++) {
            $output[$this->keys[$i]] = $this->values[$i];
        }
        return json_encode($output);
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->containsKey($offset);
    }

    /**
     * @param mixed $offset
     * @return mixed
     * @throws \OutOfRangeException
     */
    public function offsetGet($offset)
    {
        if (!$this->offsetExists($offset)) {
            throw new ArgumentOutOfRangeException('offset', $offset);
        }
        return $this->values[$this->keys->indexOf($offset)];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        if (!$this->containsKey($offset)) {
            $this->add($offset, $value);
        }
        else {
            $this->values[$this->keys->indexOf($offset)] = $value;
        }
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }

    /**
     * @param $key
     * @return bool
     */
    public function remove($key)
    {
        $result = false;

        if ($this->containsKey($key)) {
            $index = $this->keys->indexOf($key);
            $this->keys->removeAt($index);
            $this->values->removeAt($index);
            $result = true;
        }

        return $result;
    }

    /**
     * @return string
     */
    public function serialize()
    {
        $output = [];

        for ($i = 0; $i < $this->keys->count(); $i++) {
            $output[$this->keys[$i]] = $this->values[$i];
        }
        return serialize($output);
    }

    /**
     * @param string $data
     */
    public function unserialize($data)
    {
        $this->keys->clear();
        $this->values->clear();
        $array = unserialize($data);

        foreach ($array as $key => $value) {
            $this->add($key, $value);
        }
    }
}
