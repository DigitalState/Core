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
     * Cast parameters to object
     *
     * @param boolean $minimal
     * @return \stdClass
     */
    public function toObject(bool $minimal = false);
}
