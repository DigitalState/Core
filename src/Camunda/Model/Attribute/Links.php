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
    private $links; # region accessors

    /**
     * Set links
     *
     * @param array $links
     * @return object
     */
    public function setLinks(array $links)
    {
        $this->links = $links;

        return $this;
    }

    /**
     * Get links
     *
     * @return array
     */
    public function getLinks(): array
    {
        return $this->links;
    }

    # endregion
}
