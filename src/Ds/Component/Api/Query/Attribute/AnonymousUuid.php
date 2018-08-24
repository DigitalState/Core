<?php

namespace Ds\Component\Api\Query\Attribute;

/**
 * Trait AnonymousUuid
 * 
 * @package Ds\Component\Api
 */
trait AnonymousUuid
{
    /**
     * @var string
     */
    protected $anonymousUuid; # region accessors

    /**
     * Set anonymous uuid
     *
     * @param string $anonymousUuid
     * @return \Ds\Component\Api\Query\Parameters
     */
    public function setAnonymousUuid($anonymousUuid)
    {
        $this->anonymousUuid = $anonymousUuid;
        $this->_anonymousUuid = true;

        return $this;
    }

    /**
     * Get anonymous uuid
     *
     * @return string
     */
    public function getAnonymousUuid()
    {
        return $this->anonymousUuid;
    }

    # endregion

    /**
     * @var boolean
     */
    protected $_anonymousUuid;
}
