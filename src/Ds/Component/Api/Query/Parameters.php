<?php

namespace Ds\Component\Api\Query;

/**
 * Interface Parameters
 */
interface Parameters
{
    /**
     * Cast parameters to array
     *
     * @param boolean $minimal
     * @return \stdClass
     */
    public function toObject($minimal = false);
}
