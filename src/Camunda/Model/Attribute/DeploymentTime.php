<?php

namespace Ds\Component\Camunda\Model\Attribute;

use DateTime;

/**
 * Trait DeploymentTime
 *
 * @package Ds\Component\Camunda
 */
trait DeploymentTime
{
    /**
     * @var \DateTime
     */
    private $deploymentTime; # region accessors

    /**
     * Set follow up
     *
     * @param \DateTime $deploymentTime
     * @return object
     */
    public function setDeploymentTime(?DateTime $deploymentTime)
    {
        $this->deploymentTime = $deploymentTime;

        return $this;
    }

    /**
     * Get follow up
     *
     * @return \DateTime
     */
    public function getDeploymentTime(): ?DateTime
    {
        return $this->deploymentTime;
    }

    # endregion
}
