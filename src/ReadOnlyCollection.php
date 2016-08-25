<?php

namespace Collections;

class ReadOnlyCollection implements CollectionInterface
{
    protected $collection;

    /**
     * ReadOnlyCollection constructor.
     * @param CollectionInterface $collection
     */
    public function __construct(CollectionInterface $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @param array $array
     * @param $index
     * @return mixed
     */
    public function copyTo(array &$array, $index)
    {
        return $this->collection->copyTo($array, $index);
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->collection->count();
    }

    public function getIterator()
    {
        return $this->collection->getIterator();
    }
}
