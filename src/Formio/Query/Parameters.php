<?php

namespace Ds\Component\Formio\Query;

/**
 * Interface Parameters
 *
 * @package Ds\Component\Formio
 */
interface Parameters
{
    /**
     * Cast parameters to array
     *
     * @param boolean $minimal
     * @return \stdClass
     */
    public function toObject(bool $minimal = false);
}
