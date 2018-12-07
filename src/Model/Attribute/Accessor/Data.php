<?php

namespace Ds\Component\Model\Attribute\Accessor;

use OutOfRangeException;

/**
 * Trait Data
 *
 * @package Ds\Component\Model
 */
trait Data
{
    /**
     * Set data
     *
     * @param array $data
     * @return object
     */
    public function setData(?array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return array
     * @throws \OutOfRangeException
     */
    public function getData(): ?array
    {
        return $this->data;
    }
}
