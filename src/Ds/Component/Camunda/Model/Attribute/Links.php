<?php

namespace Ds\Component\Camunda\Model\Attribute;

/**
 * Trait Links
 *
 * @package Ds\Component\Camunda
 */
trait Links
{
    /**
     * @var array
     */
    protected $links; # region accessors

    /**
     * Set links
     *
     * @param array $links
     * @return object
     */
    public function setLinks($links)
    {
        $this->links = $links;

        return $this;
    }

    /**
     * Get links
     *
     * @return array
     */
    public function getLinks()
    {
        return $this->links;
    }

    # endregion
}
