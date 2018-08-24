<?php

namespace Ds\Component\Camunda\Query\Attribute;

/**
 * Trait SortOrder
 *
 * @package Ds\Component\Camunda
 */
trait SortOrder
{
    /**
     * @var string
     */
    protected $sortOrder; # region accessors

    /**
     * Set sort order
     *
     * @param string $sortOrder
     * @return object
     */
    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
        $this->_sortOrder = null !== $sortOrder;

        return $this;
    }

    /**
     * Get sort order
     *
     * @return string
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    # endregion

    /**
     * @var boolean
     */
    protected $_sortOrder;
}
