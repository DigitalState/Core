<?php

namespace Ds\Component\Camunda\Model\Attribute;

/**
 * Trait ParentTaskId
 *
 * @package Ds\Component\Camunda
 */
trait ParentTaskId
{
    /**
     * @var string
     */
    private $parentTaskId; # region accessors

    /**
     * Set parent task id
     *
     * @param string $parentTaskId
     * @return object
     */
    public function setParentTaskId(?string $parentTaskId)
    {
        $this->parentTaskId = $parentTaskId;

        return $this;
    }

    /**
     * Get parent task id
     *
     * @return string
     */
    public function getParentTaskId(): ?string
    {
        return $this->parentTaskId;
    }

    # endregion
}
