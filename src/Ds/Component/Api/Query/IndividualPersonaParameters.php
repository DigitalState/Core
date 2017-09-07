<?php

namespace Ds\Component\Api\Query;

/**
 * Class IndividualPersonaParameters
 *
 * @package Ds\Component\Api
 */
class IndividualPersonaParameters extends AbstractParameters
{
    protected $individualUuid;
    protected $_individualUuid;

    public function setIndividualUuid($individualUuid)
    {
        $this->individualUuid = $individualUuid;
        $this->_individualUuid = true;

        return $this;
    }

    public function getIndividualUuid()
    {
        return $this->individualUuid;
    }

    public function __construct()
    {
    }
}
