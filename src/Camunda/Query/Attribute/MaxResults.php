<?php

namespace Ds\Component\Camunda\Query\Attribute;

/**
 * Trait MaxResults
 *
 * @package Ds\Component\Camunda
 */
trait MaxResults
{
    /**
     * @var integer
     */
    private $maxResults; # region accessors

    /**
     * Set max results
     *
     * @param integer $maxResults
     * @return object
     */
    public function setMaxResults(?int $maxResults)
    {
        $this->maxResults = $maxResults;
        $this->_maxResults = null !== $maxResults;

        return $this;
    }

    /**
     * Get max results
     *
     * @return integer
     */
    public function getMaxResults(): ?int
    {
        return $this->maxResults;
    }

    # endregion

    /**
     * @var boolean
     */
    private $_maxResults;
}
