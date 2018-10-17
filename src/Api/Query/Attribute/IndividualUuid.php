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
    protected $individualUuid; # region accessors

    /**
     * Set individual uuid
     *
     * @param string $individualUuid
     * @return \Ds\Component\Api\Query\Parameters
     */
    public function setIndividualUuid($individualUuid)
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
    public function getIndividualUuid()
    {
        return $this->individualUuid;
    }

    # endregion

    /**
     * @var boolean
     */
    protected $_individualUuid;
}
