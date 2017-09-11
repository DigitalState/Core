<?php

namespace Ds\Component\Camunda\Query\Attribute;

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
        $this->_key = null !== $key;

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

    /**
     * @var boolean
     */
    protected $_key;
}
