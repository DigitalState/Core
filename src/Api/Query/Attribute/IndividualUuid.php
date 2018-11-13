<?php

namespace Ds\Component\Api\Query\Attribute;

/**
 * Trait IndividualUuid
 *
 * @package Ds\Component\Api
 */
trait IndividualUuid
{
    /**
     * @var string
     */
    private $individualUuid; # region accessors

    /**
     * Set individual uuid
     *
     * @param string $individualUuid
     * @return object
     */
    public function setIndividualUuid(?string $individualUuid)
    {
        $this->individualUuid = $individualUuid;
        $this->_individualUuid = true;

        return $this;
    }

    /**
     * Get individual uuid
     *
     * @return string
     */
    public function getIndividualUuid(): ?string
    {
        return $this->individualUuid;
    }

    # endregion

    /**
     * @var boolean
     */
    private $_individualUuid;
}
