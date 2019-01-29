<?php

namespace Ds\Component\Camunda\Query;

/**
 * Interface Parameters
 *
 * @package Ds\Component\Camunda
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
