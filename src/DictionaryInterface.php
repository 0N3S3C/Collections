<?php

namespace Collections;

interface DictionaryInterface extends CollectionInterface, \ArrayAccess
{
    public function add($key, $value);
    public function clear();
    public function contains($key);
    public function getKeys();
    public function getValues();
    public function remove($key);
}
