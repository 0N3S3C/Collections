<?php

namespace Collections;

trait EnumerableExtensions
{
    /**
     * @param callable $predicate
     * @return bool
     */
    public function all(callable $predicate)
    {
        return Enumerable::all($this, $predicate);
    }

    /**
     * @param callable|null $predicate
     * @return bool
     */
    public function any(callable $predicate = null)
    {
        return Enumerable::any($this, $predicate);
    }

    /**
     * @param $object
     * @return bool
     */
    public function contains($object)
    {
        return Enumerable::contains($this, $object);
    }

    /**
     * @return int
     */
    public function count()
    {
        return Enumerable::count($this);
    }

    /**
     * @param callable $predicate
     * @return int
     */
    public function countWhere(callable $predicate)
    {
        return Enumerable::countWhere($this, $predicate);
    }

    /**
     * @return Collection
     */
    public function distinct()
    {
        return Enumerable::distinct($this);
    }

    /**
     * @param EqualityComparerInterface $comparer
     * @return Collection
     */
    public function distinctWhere(EqualityComparerInterface $comparer)
    {
        return Enumerable::distinctWhere($this, $comparer);
    }

    /**
     * @param $index
     * @return mixed|null
     * @throws IndexOutOfRangeException
     * @throws InvalidArgumentException
     */
    public function elementAt($index)
    {
        return Enumerable::elementAt($this, $index);
    }

    /**
     * @param $index
     * @param null $default
     * @return mixed|null
     * @throws InvalidArgumentException
     */
    public function elementAtOrDefault($index, $default = null)
    {
        return Enumerable::elementAtOrDefault($this, $index, $default);
    }

    /**
     * @param array $array
     * @return Collection
     */
    public function except(array $array)
    {
        return Enumerable::except($this, $array);
    }

    /**
     * @param array $array
     * @param EqualityComparerInterface $comparer
     * @return Collection
     */
    public function exceptWhere(array $array, EqualityComparerInterface $comparer)
    {
        return Enumerable::exceptWhere($this, $array, $comparer);
    }

    /**
     * @return mixed|null
     * @throws InvalidOperationException
     */
    public function first()
    {
        return Enumerable::first($this);
    }

    /**
     * @param callable $predicate
     * @return mixed
     * @throws InvalidOperationException
     */
    public function firstWhere(callable $predicate)
    {
        return Enumerable::firstWhere($this, $predicate);
    }

    /**
     * @param null $default
     * @return mixed
     */
    public function firstOrDefault($default = null)
    {
        return Enumerable::firstOrDefault($this, $default);
    }

    /**
     * @param callable $predicate
     * @param null $default
     * @return mixed
     */
    public function firstOrDefaultWhere(callable $predicate, $default = null)
    {
        return Enumerable::firstOrDefaultWhere($this, $predicate, $default);
    }

    /**
     * @return mixed|null
     * @throws InvalidOperationException
     */
    public function last()
    {
        return Enumerable::last($this);
    }

    /**
     * @param callable $predicate
     * @return mixed
     * @throws InvalidOperationException
     */
    public function lastWhere(callable $predicate)
    {
        return Enumerable::lastWhere($this, $predicate);
    }

    /**
     * @param null $default
     * @return mixed|null
     */
    public function lastOrDefault($default = null)
    {
        return Enumerable::lastOrDefault($this, $default);
    }

    /**
     * @param callable $predicate
     * @param null $default
     * @return mixed
     */
    public function lastOrDefaultWhere(callable $predicate, $default = null)
    {
        return Enumerable::lastOrDefaultWhere($this, $predicate, $default);
    }

    /**
     * @param $type
     * @return Collection
     */
    public function ofType($type)
    {
        return Enumerable::ofType($this, $type);
    }

    /**
     * @param $number
     * @return Collection
     */
    public function skip($number)
    {
        return Enumerable::skip($this, $number);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return Enumerable::toArray($this);
    }

    /**
     * @param callable $predicate
     * @return Collection
     */
    public function where(callable $predicate)
    {
        return Enumerable::where($this, $predicate);
    }
}
