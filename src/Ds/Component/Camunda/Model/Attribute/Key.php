<?php

namespace Ds\Component\Camunda\Model\Attribute;

/**
 * Trait Key
 *
 * @package Ds\Component\Camunda
 */
trait Key
{
    /**
     * @var string
     */
    protected $key; # region accessors

    /**
     * Set key
     *
     * @param string $key
     * @return object
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    # endregion
}
