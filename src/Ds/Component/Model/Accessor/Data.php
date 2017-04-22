<?php

namespace Ds\Component\Model\Accessor;

use OutOfRangeException;

/**
 * Trait Data
 */
trait Data
{
    /**
     * Set data
     *
     * @param array $data
     * @return object
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @param string $property
     * @return array
     * @throws \OutOfRangeException
     */
    public function getData($property = null)
    {
        if (null === $property) {
            return $this->data;
        }

        if (!array_key_exists($property, $this->data)) {
            throw new OutOfRangeException('Array property does not exist.');
        }

        return $this->data[$property];
    }
}
