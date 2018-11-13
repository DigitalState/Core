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
    private $sortBy; # region accessors

    /**
     * Set sort by
     *
     * @param string $sortBy
     * @return object
     */
    public function setSortBy(?string $sortBy)
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
    public function getSortBy(): ?string
    {
        return $this->sortBy;
    }

    # endregion

    /**
     * @var boolean
     */
    private $_sortBy;
}
