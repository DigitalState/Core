<?php

namespace Ds\Component\System\Query;

/**
 * Interface Parameters
 *
 * @package Ds\Component\System
 */
interface Parameters
{
    /**
     * Cast parameters to object
     *
     * @param boolean $minimal
     * @return \stdClass
     */
    public function toObject($minimal = false);
}
