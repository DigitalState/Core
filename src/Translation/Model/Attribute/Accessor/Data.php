<?php

namespace Ds\Component\Translation\Model\Attribute\Accessor;

/**
 * Trait Data
 *
 * @package Ds\Component\Translation
 */
trait Data
{
    /**
     * Set data
     *
     * @param array $data
     * @return object
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}
