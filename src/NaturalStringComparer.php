<?php

namespace Collections;

class NaturalStringComparer implements ComparerInterface
{
    /**
     * @param $x
     * @param $y
     * @return int
     */
    public function compare($x, $y)
    {
        return strnatcmp($x, $y);
    }
}
