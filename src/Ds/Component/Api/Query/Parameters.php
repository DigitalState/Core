<?php

namespace Ds\Component\Api\Query;

/**
 * Interface Parameters
 *
 * @package Ds\Component\Api
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
