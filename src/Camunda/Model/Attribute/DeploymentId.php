<?php

namespace Ds\Component\Camunda\Model\Attribute;

/**
 * Trait DeploymentId
 *
 * @package Ds\Component\Camunda
 */
trait DeploymentId
{
    /**
     * @var string
     */
    private $deploymentId; # region accessors

    /**
     * Set deployment id
     *
     * @param string $deploymentId
     * @return object
     */
    public function setDeploymentId(?string $deploymentId)
    {
        $this->deploymentId = $deploymentId;

        return $this;
    }

    /**
     * Get deployment id
     *
     * @return string
     */
    public function getDeploymentId(): ?string
    {
        return $this->deploymentId;
    }

    # endregion
}
