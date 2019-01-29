<?php

namespace Ds\Component\Formio\Model\Attribute;

/**
 * Trait MachineName
 *
 * @package Ds\Component\Formio
 */
trait MachineName
{
    /**
     * @var string
     */
    private $machineName; # region accessors

    /**
     * Set machine name
     *
     * @param string $machineName
     * @return object
     */
    public function setMachineName(?string $machineName)
    {
        $this->machineName = $machineName;

        return $this;
    }

    /**
     * Get machine name
     *
     * @return string
     */
    public function getMachineName(): ?string
    {
        return $this->machineName;
    }

    # endregion
}
