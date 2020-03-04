<?php

namespace Ds\Component\Camunda\Query\Attribute;

/**
 * Trait TaskIdIn
 *
 * @package Ds\Component\Camunda
 */
trait TaskIdIn
{
    /**
     * @var array
     */
    private $taskIdIn; # region accessors

    /**
     * Set task id in
     *
     * @param array $taskIdIn
     * @return object
     */
    public function setTaskIdIn(array $taskIdIn)
    {
        $this->taskIdIn = $taskIdIn;
        $this->_taskIdIn = null !== $taskIdIn;

        return $this;
    }

    /**
     * Get taskIdIn
     *
     * @return array
     */
    public function getTaskIdIn(): array
    {
        return $this->taskIdIn;
    }

    # endregion

    /**
     * @var boolean
     */
    private $_taskIdIn;
}
