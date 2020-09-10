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
     * @param string $type
     * @return \stdClass
     */
    public function toObject(bool $minimal = false, $type = 'query');
}
