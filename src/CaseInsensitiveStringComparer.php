<?php

namespace Collections;

class CaseInsensitiveStringComparer implements ComparerInterface
{
    /**
     * @param $x
     * @param $y
     * @return int
     */
    public function compare($x, $y)
    {
        return strcasecmp($x, $y);
    }
}
