<?php

namespace Collections;

use Collections\Exceptions\ArgumentNotNumericException;
use Collections\Exceptions\ArgumentOutOfRangeException;

trait EnumerableExtensions
{
    /**
     * @param callable $predicate
     * @return bool
     */
    public function all(callable $predicate)
    {
        $satisfied = true;

        foreach ($this as $object) {
            $satisfied = call_user_func($predicate, $object);

            if (!$satisfied) {
                break;
            }
        }

        return $satisfied;
    }

    /**
     * @param callable|null $predicate
     * @return bool
     */
    public function any(callable $predicate = null)
    {
        $qualifies = false;

        if ($predicate == null) {

            $predicate = function () {
                return true;
            };
        }

        foreach ($this as $object) {

            if (call_user_func($predicate, $object)) {
                $qualifies = true;
                break;
            }
        }

        return $qualifies;
    }

    /**
     * @param $object
     * @return bool
     */
    public function contains($object)
    {
        $inArray = false;

        foreach ($this as $item) {

            if ($item == $object) {
                $inArray = true;
                break;
            }
        }

        return $inArray;
    }

    /**
     * @return int
     */
    public function count()
    {
        $counter = 0;

        foreach ($this as $object) {
            $counter++;
        }

        return $counter;
    }

    /**
     * @param callable $predicate
     * @return int
     */
    public function countWhere(callable $predicate)
    {
        $ctr = 0;

        foreach ($this as $object) {

            if (call_user_func($predicate, $object)) {
                $ctr++;
            }
        }

        return $ctr;
    }

    /**
     * @return Enumerable
     */
    public function distinct()
    {
        return $this->distinctWhere(EqualityComparer::create());
    }

    /**
     * @param EqualityComparerInterface $comparer
     * @return Enumerable
     */
    public function distinctWhere(EqualityComparerInterface $comparer)
    {
        $results = [];

        foreach ($this as $object) {
            $inArray = false;

            foreach ($results as $result) {

                if ($comparer->equals($object, $result)) {
                    $inArray = true;
                }
            }

            if (!$inArray) {
                $results[] = $object;
            }
        }

        return new Enumerable($results);
    }

    /**
     * @param $index
     * @return mixed|null
     * @throws \InvalidArgumentException
     * @throws \OutOfRangeException
     */
    public function elementAt($index)
    {
        if (!is_numeric($index)) {
            throw new ArgumentNotNumericException('index', $index);
        }

        if ($index < 0 || $index >= $this->count()) {
            throw new ArgumentOutOfRangeException('index', $index);
        }
        $counter = 0;
        $found = false;
        $returnValue = null;

        foreach ($this as $object) {

            if ($counter == $index) {
                $returnValue = $object;
                $found = true;
                break;
            }
            $counter++;
        }

        if (!$found) {
            throw new ArgumentOutOfRangeException('index', $index);
        }

        return $returnValue;
    }

    /**
     * @param $index
     * @param null $default
     * @return mixed|null
     * @throws \InvalidArgumentException
     */
    public function elementAtOrDefault($index, $default = null)
    {
        if (!is_numeric($index)) {
            throw new ArgumentNotNumericException('index', $index);
        }

        if ($index < 0 || $index >= $this->count()) {
            return null;
        }
        $counter = 0;
        $returnValue = $default;

        foreach ($this as $object) {

            if ($counter == $index) {
                $returnValue = $object;
                break;
            }
            $counter++;
        }

        return $returnValue;
    }

    /**
     * @param array $array
     * @return Enumerable
     */
    public function except(array $array)
    {
        return $this->exceptWhere($array, EqualityComparer::create());
    }

    /**
     * @param array $array
     * @param EqualityComparerInterface $comparer
     * @return Enumerable
     */
    public function exceptWhere(array $array, EqualityComparerInterface $comparer)
    {
        $resultArray = $this->toArray();

        foreach ($this as $outerKey => $outerValue) {

            foreach ($array as $exclude) {

                if ($comparer->equals($outerValue, $exclude) && isset($resultArray[$outerKey])) {
                    unset($resultArray[$outerKey]);
                }
            }
        }

        return new Enumerable(array_values($resultArray));
    }

    /**
     * @return mixed|null
     * @throws \UnderflowException
     */
    public function first()
    {
        if (!$this->count($this)) {
            throw new \UnderflowException("Cannot get first element of empty enumeration");
        }
        $returnValue = null;

        foreach ($this as $object) {
            $returnValue = $object;
            break;
        }

        return $returnValue;
    }

    /**
     * @param null $default
     * @return mixed
     */
    public function firstOrDefault($default = null)
    {
        $returnValue = $default;

        foreach ($this as $object) {
            $returnValue = $object;
            break;
        }

        return $returnValue;
    }

    /**
     * @return mixed|null
     * @throws \UnderflowException
     */
    public function last()
    {
        if (!$this->count()) {
            throw new \UnderflowException("Cannot get last element of empty enumeration");
        }

        return $this->elementAt($this->count() - 1);
    }

    /**
     * @param null $default
     * @return mixed|null
     */
    public function lastOrDefault($default = null)
    {
        if (!$this->count()) {
            return $default;
        }

        return $this->elementAt($this->count() - 1);
    }

    /**
     * @param $type
     * @return Enumerable
     */
    public function ofType($type)
    {
        $objects = [];

        foreach ($this as $object) {

            if (is_a($object, $type)) {
                $objects[] = $object;
            }
        }

        return new Enumerable($objects);
    }

    /**
     * @param $number
     * @return Enumerable
     */
    public function skip($number)
    {
        $skip = $number;
        $objects = [];

        foreach ($this as $object) {

            if (!$skip) {
                $results[] = $object;
            }
            --$skip;
        }

        return new Enumerable($objects);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $array = [];

        foreach ($this as $key => $value) {
            $array[$key] = $value;
        }

        return $array;
    }

    /**
     * @param callable $predicate
     * @return Enumerable
     */
    public function where(callable $predicate)
    {
        $results = [];

        foreach ($this as $object) {

            if (call_user_func($predicate, $object)) {
                $results[] = $object;
            }
        }

        return new Enumerable($results);
    }
}
