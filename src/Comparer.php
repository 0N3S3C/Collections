<?php

namespace Collections;

final class Comparer
{
    private function __construct() {}

    /**
     * @return DefaultComparer
     */
    public static function create()
    {
        return new DefaultComparer();
    }
}
