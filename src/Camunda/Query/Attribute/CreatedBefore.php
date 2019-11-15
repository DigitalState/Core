<?php

namespace Ds\Component\Camunda\Query\Attribute;

use DateTime;

/**
 * Trait CreatedBefore
 *
 * @package Ds\Component\Camunda
 */
trait CreatedBefore
{
    /**
     * @var \DateTime
     */
    private $createdBefore; # region accessors

    /**
     * Set created before
     *
     * @param \DateTime $createdBefore
     * @return object
     */
    public function setCreatedBefore(?DateTime $createdBefore)
    {
        $this->createdBefore = $createdBefore;
        $this->_createdBefore = null !== $createdBefore;

        return $this;
    }

    /**
     * Get created before
     *
     * @return \DateTime
     */
    public function getCreatedBefore(): ?DateTime
    {
        return $this->createdBefore;
    }

    # endregion

    /**
     * @var boolean
     */
    private $_createdBefore;
}
