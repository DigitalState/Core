<?php

namespace Ds\Component\Camunda\Query\Attribute;

use DateTime;

/**
 * Trait CreatedAfter
 *
 * @package Ds\Component\Camunda
 */
trait CreatedAfter
{
    /**
     * @var \DateTime
     */
    private $createdAfter; # region accessors

    /**
     * Set created after
     *
     * @param \DateTime $createdAfter
     * @return object
     */
    public function setCreatedAfter(?DateTime $createdAfter)
    {
        $this->createdAfter = $createdAfter;
        $this->_createdAfter = null !== $createdAfter;

        return $this;
    }

    /**
     * Get created after
     *
     * @return \DateTime
     */
    public function getCreatedAfter(): ?DateTime
    {
        return $this->createdAfter;
    }

    # endregion

    /**
     * @var boolean
     */
    private $_createdAfter;
}
