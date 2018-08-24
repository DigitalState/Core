<?php

namespace Ds\Component\Camunda\Model\Attribute;

/**
 * Trait FormKey
 *
 * @package Ds\Component\Camunda
 */
trait FormKey
{
    /**
     * @var string
     */
    protected $formKey; # region accessors

    /**
     * Set form key
     *
     * @param string $formKey
     * @return object
     */
    public function setFormKey($formKey)
    {
        $this->formKey = $formKey;

        return $this;
    }

    /**
     * Get form key
     *
     * @return string
     */
    public function getFormKey()
    {
        return $this->formKey;
    }

    # endregion
}
