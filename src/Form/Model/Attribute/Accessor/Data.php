<?php

namespace Ds\Component\Form\Model\Attribute\Accessor;

/**
 * Trait Data
 *
 * @package Ds\Component\Form
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
