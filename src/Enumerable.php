<?php

namespace Collections;

final class Enumerable
{
    private function __construct() {}

    /**
     * @param EnumerableInterface $enumerable
     * @param callable $predicate
     * @return bool
     */
    public static function all(EnumerableInterface $enumerable, callable $predicate)
    {
        $satisfied = true;

        foreach ($enumerable as $object) {
            $satisfied = call_user_func($predicate, $object);

            if (!$satisfied) {
                break;
            }
        }

        return $satisfied;
    }

    /**
     * @param EnumerableInterface $enumerable
     * @param callable|null $predicate
     * @return bool
     */
    public static function any(EnumerableInterface $enumerable, callable $predicate = null)
    {
        $qualifies = false;

        if ($predicate == null) {

            $predicate = function () {
                return true;
            };
        }

        foreach ($enumerable as $object) {

            if (call_user_func($predicate, $object)) {
                $qualifies = true;
                break;
            }
        }

        return $qualifies;
    }

    /**
     * @param EnumerableInterface $enumerable
     * @param $object
     * @return bool
     */
    public static function contains(EnumerableInterface $enumerable, $object)
    {
        $inArray = false;

        foreach ($enumerable as $item) {

            if ($item == $object) {
                $inArray = true;
                break;
            }
        }

        return $inArray;
    }

    /**
     * @param EnumerableInterface $enumerable
     * @return int
     */
    public static function count(EnumerableInterface $enumerable)
    {
        $counter = 0;

        foreach ($enumerable as $object) {
            $counter++;
        }

        return $counter;
    }

    /**
     * @param EnumerableInterface $enumerable
     * @param callable $predicate
     * @return int
     */
    public static function countWhere(EnumerableInterface $enumerable, callable $predicate)
    {
        $ctr = 0;

        foreach ($enumerable as $object) {

            if (call_user_func($predicate, $object)) {
                $ctr++;
            }
        }

        return $ctr;
    }

    /**
     * @param EnumerableInterface $enumerable
     * @return Collection
     */
    public static function distinct(EnumerableInterface $enumerable)
    {
        return self::distinctWhere($enumerable, EqualityComparer::create());
    }

    /**
     * @param EnumerableInterface $enumerable
     * @param EqualityComparerInterface $comparer
     * @return Collection
     */
    public static function distinctWhere(EnumerableInterface $enumerable, EqualityComparerInterface $comparer)
    {
        $results = [];

        foreach ($enumerable as $object) {
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

        return new Collection($results);
    }

    /**
     * @param EnumerableInterface $enumerable
     * @param $index
     * @throws IndexOutOfRangeException
     * @throws InvalidArgumentException
     * @return mixed
     */
    public static function elementAt(EnumerableInterface $enumerable, $index)
    {
        if (!is_numeric($index)) {
            throw new InvalidArgumentException("Index must be numeric");
        }

        if ($index < 0 || $index >= self::count($enumerable)) {
            throw new IndexOutOfRangeException("Index {$index} is out of bounds");
        }
        $counter = 0;
        $found = false;
        $returnValue = null;

        foreach ($enumerable as $object) {

            if ($counter == $index) {
                $returnValue = $object;
                $found = true;
                break;
            }
            $counter++;
        }

        if (!$found) {
            throw new IndexOutOfRangeException("Index {$index} was not found");
        }

        return $returnValue;
    }

    /**
     * @param EnumerableInterface $enumerable
     * @param int $index
     * @param mixed $default
     * @throws InvalidArgumentException
     * @return mixed
     */
    public static function elementAtOrDefault(EnumerableInterface $enumerable, $index, $default = null)
    {
        if (!is_numeric($index)) {
            throw new InvalidArgumentException("Index must be numeric");
        }

        if ($index < 0 || $index >= self::count($enumerable)) {
            return null;
        }
        $counter = 0;
        $returnValue = $default;

        foreach ($enumerable as $object) {

            if ($counter == $index) {
                $returnValue = $object;
                break;
            }
            $counter++;
        }

        return $returnValue;
    }

    /**
     * @param EnumerableInterface $enumerable
     * @param array $array
     * @return Collection
     */
    public static function except(EnumerableInterface $enumerable, array $array)
    {
        return self::exceptWhere($enumerable, $array, EqualityComparer::create());
    }

    /**
     * @param EnumerableInterface $enumerable
     * @param array $array
     * @param EqualityComparerInterface $comparer
     * @return Collection
     */
    public static function exceptWhere(EnumerableInterface $enumerable, array $array, EqualityComparerInterface $comparer)
    {
        $resultArray = self::toArray($enumerable);

        foreach ($enumerable as $outerKey => $outerValue) {

            foreach ($array as $exclude) {

                if ($comparer->equals($outerValue, $exclude) && isset($resultArray[$outerKey])) {
                    unset($resultArray[$outerKey]);
                }
            }
        }

        return new Collection(array_values($resultArray));
    }

    /**
     * @param EnumerableInterface $enumerable
     * @throws InvalidOperationException
     * @return mixed
     */
    public static function first(EnumerableInterface $enumerable)
    {
        if (!self::count($enumerable)) {
            throw new InvalidOperationException("Cannot get first element of empty enumeration");
        }
        $returnValue = null;

        foreach ($enumerable as $object) {
            $returnValue = $object;
            break;
        }

        return $returnValue;
    }

    /**
     * @param EnumerableInterface $enumerable
     * @param callable $predicate
     * @throws InvalidOperationException
     * @return mixed
     */
    public static function firstWhere(EnumerableInterface $enumerable, callable $predicate)
    {
        $foundItems = [];

        foreach ($enumerable as $object) {

            if (call_user_func($predicate, $object)) {
                $foundItems[] = $object;
            }
        }

        if (!count($foundItems)) {
            throw new InvalidOperationException("Cannot get first element of empty enumeration");
        }

        return $foundItems[0];
    }

    /**
     * @param EnumerableInterface $enumerable
     * @param mixed $default
     * @return mixed
     */
    public static function firstOrDefault(EnumerableInterface $enumerable, $default = null)
    {
        $returnValue = $default;

        foreach ($enumerable as $object) {
            $returnValue = $object;
            break;
        }

        return $returnValue;
    }

    /**
     * @param EnumerableInterface $enumerable
     * @param mixed $default
     * @param callable $predicate
     * @return mixed
     */
    public static function firstOrDefaultWhere(EnumerableInterface $enumerable, callable $predicate, $default = null)
    {
        $returnValue = $default;

        foreach ($enumerable as $object) {

            if (call_user_func($predicate, $object)) {
                $returnValue = $object;
                break;
            }
        }

        return $returnValue;
    }

    /**
     * @param EnumerableInterface $enumerable
     * @throws InvalidOperationException
     * @return mixed
     */
    public static function last(EnumerableInterface $enumerable)
    {
        if (!self::count($enumerable)) {
            throw new InvalidOperationException("Cannot get last element of empty enumeration");
        }

        return self::elementAt($enumerable, self::count($enumerable) - 1);
    }

    /**
     * @param EnumerableInterface $enumerable
     * @param callable $predicate
     * @throws InvalidOperationException
     * @return mixed
     */
    public static function lastWhere(EnumerableInterface $enumerable, callable $predicate)
    {
        $foundItems = [];

        foreach ($enumerable as $object) {

            if (call_user_func($predicate, $object)) {
                $foundItems[] = $object;
            }
        }

        if (!count($foundItems)) {
            throw new InvalidOperationException("No elements found");
        }

        return $foundItems[count($foundItems) - 1];
    }

    /**
     * @param EnumerableInterface $enumerable
     * @param mixed $default
     * @return mixed
     */
    public static function lastOrDefault(EnumerableInterface $enumerable, $default = null)
    {
        if (!self::count($enumerable)) {
            return $default;
        }

        return self::elementAt($enumerable, self::count($enumerable) - 1);
    }

    /**
     * @param EnumerableInterface $enumerable
     * @param mixed $default
     * @param callable $predicate
     * @return mixed
     */
    public static function lastOrDefaultWhere(EnumerableInterface $enumerable, callable $predicate, $default = null)
    {
        $foundItems = [];

        foreach ($enumerable as $object) {

            if (call_user_func($predicate, $object)) {
                $foundItems[] = $object;
            }
        }

        if (!count($foundItems)) {
            return $default;
        }

        return $foundItems[count($foundItems) - 1];
    }

    /**
     * @param EnumerableInterface $enumerable
     * @param $type
     * @return Collection
     */
    public static function ofType(EnumerableInterface $enumerable, $type)
    {
        $objects = [];

        foreach ($enumerable as $object) {

            if (is_a($object, $type)) {
                $objects[] = $object;
            }
        }

        return new Collection($objects);
    }

    /**
     * @param EnumerableInterface $enumerable
     * @param $number
     * @return Collection
     */
    public static function skip(EnumerableInterface $enumerable, $number)
    {
        $skip = $number;
        $objects = [];

        foreach ($enumerable as $object) {

            if (!$skip) {
                $results[] = $object;
            }
            --$skip;
        }

        return new Collection($objects);
    }

    /**
     * @param EnumerableInterface $enumerable
     * @return array
     */
    public static function toArray(EnumerableInterface $enumerable)
    {
        $array = [];

        foreach ($enumerable as $key => $value) {
            $array[$key] = $value;
        }

        return $array;
    }

    /**
     * @param EnumerableInterface $enumerable
     * @param callable $predicate
     * @return Collection
     */
    public static function where(EnumerableInterface $enumerable, callable $predicate)
    {
        $results = [];

        foreach ($enumerable as $object) {

            if (call_user_func($predicate, $object)) {
                $results[] = $object;
            }
        }

        return new Collection($results);
    }
}
