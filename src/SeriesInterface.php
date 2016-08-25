<?php

namespace Collections;

interface SeriesInterface extends CollectionInterface, \ArrayAccess
{
    public function add($object);
    public function clear();
    public function contains($object);
    public function indexOf($object);
    public function insert($index, $object);
    public function remove($object);
    public function removeAt($index);
}
