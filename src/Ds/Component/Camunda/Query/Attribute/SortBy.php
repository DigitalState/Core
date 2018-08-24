<?php

namespace Ds\Component\Camunda\Query\Attribute;

/**
 * Trait SortBy
 *
 * @package Ds\Component\Camunda
 */
trait SortBy
{
    /**
     * @var string
     */
    protected $sortBy; # region accessors

    /**
     * Set sort by
     *
     * @param string $sortBy
     * @return object
     */
    public function setSortBy($sortBy)
    {
        $this->sortBy = $sortBy;
        $this->_sortBy = null !== $sortBy;

        return $this;
    }

    /**
     * Get sort by
     *
     * @return string
     */
    public function getSortBy()
    {
        return $this->sortBy;
    }

    # endregion

    /**
     * @var boolean
     */
    protected $_sortBy;
}
