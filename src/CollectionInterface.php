<?php

namespace Collections;

interface CollectionInterface extends EnumerableInterface, \Countable
{
    public function copyTo(array &$array, $index);
}
