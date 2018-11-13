<?php

namespace Ds\Component\Formio\Model\Attribute;

use DateTime;

/**
 * Trait Updated
 *
 * @package Ds\Component\Formio
 */
trait Updated
{
    /**
     * @var \DateTime
     */
    private $updated; # region accessors

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return object
     */
    public function setUpdated(?DateTime $updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated(): ?DateTime
    {
        return $this->updated;
    }

    # endregion
}
