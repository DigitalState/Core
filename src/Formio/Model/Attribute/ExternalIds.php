<?php

namespace Ds\Component\Formio\Model\Attribute;

/**
 * Trait ExternalIds
 *
 * @package Ds\Component\Formio
 */
trait ExternalIds
{
    /**
     * @var array
     */
    private $externalIds; # region accessors

    /**
     * Set external ids
     *
     * @param array $externalIds
     * @return object
     */
    public function setExternalIds(array $externalIds)
    {
        $this->externalIds = $externalIds;

        return $this;
    }

    /**
     * Get external ids
     *
     * @return array
     */
    public function getExternalIds(): array
    {
        return $this->externalIds;
    }

    # endregion
}
