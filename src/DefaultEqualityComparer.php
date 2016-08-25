<?php

namespace Collections;

class DefaultEqualityComparer implements EqualityComparerInterface
{
    /**
     * @param $x
     * @param $y
     * @return bool
     */
    public function equals($x, $y)
    {
        return $x == $y;
    }
}
