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
    protected $maxResults; # region accessors

    /**
     * Set max results
     *
     * @param integer $maxResults
     * @return object
     */
    public function setMaxResults($maxResults)
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
    public function getMaxResults()
    {
        return $this->maxResults;
    }

    # endregion

    /**
     * @var boolean
     */
    protected $_maxResults;
}
