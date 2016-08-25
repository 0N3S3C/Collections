<?php

namespace Collections;

final class EqualityComparer
{
    private function __construct() {}

    /**
     * @return DefaultEqualityComparer
     */
    public static function create()
    {
        return new DefaultEqualityComparer();
    }
}
