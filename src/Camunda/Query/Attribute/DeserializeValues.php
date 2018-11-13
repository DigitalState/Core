<?php

namespace Ds\Component\Camunda\Query\Attribute;

/**
 * Trait DeserializeValues
 *
 * @package Ds\Component\Camunda
 */
trait DeserializeValues
{
    /**
     * @var boolean
     */
    private $deserializeValues; # region accessors

    /**
     * Set deserialize values
     *
     * @param boolean $deserializeValues
     * @return object
     */
    public function setDeserializeValues(?bool $deserializeValues)
    {
        $this->deserializeValues = $deserializeValues;
        $this->_deserializeValues = null !== $deserializeValues;

        return $this;
    }

    /**
     * Get deserializeValues
     *
     * @return boolean
     */
    public function getDeserializeValues(): ?bool
    {
        return $this->deserializeValues;
    }

    # endregion

    /**
     * @var boolean
     */
    private $_deserializeValues;
}
