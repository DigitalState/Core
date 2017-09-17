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
    protected $deserializeValues; # region accessors

    /**
     * Set deserialize values
     *
     * @param string $deserializeValues
     * @return object
     */
    public function setDeserializeValues($deserializeValues)
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
    public function getDeserializeValues()
    {
        return $this->deserializeValues;
    }

    # endregion

    /**
     * @var boolean
     */
    protected $_deserializeValues;
}
