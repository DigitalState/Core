<?php

namespace Ds\Component\Camunda\Model\Attribute;

use DateTime;

/**
 * Trait Created
 *
 * @package Ds\Component\Camunda
 */
trait Created
{
    /**
     * @var \DateTime
     */
    private $created; # region accessors

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return object
     */
    public function setCreated(?DateTime $created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated(): ?DateTime
    {
        return $this->created;
    }

    # endregion
}
