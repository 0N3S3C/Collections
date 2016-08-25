<?php

namespace Collections;

class DefaultComparer implements ComparerInterface
{
    /**
     * @param $x
     * @param $y
     * @return int
     */
    public function compare($x, $y)
    {
        if ($x < $y) {
            return -1;
        }
        else if ($x > $y) {
            return 1;
        }
        else {
            return 0;
        }
    }
}
