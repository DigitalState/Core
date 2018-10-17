<?php

namespace Ds\Component\Camunda\Model\Attribute;

/**
 * Trait Category
 *
 * @package Ds\Component\Camunda
 */
trait Category
{
    /**
     * @var string
     */
    protected $category; # region accessors

    /**
     * Set category
     *
     * @param string $category
     * @return object
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    # endregion
}
