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
    private $anonymousUuid; # region accessors

    /**
     * Set anonymous uuid
     *
     * @param string $anonymousUuid
     * @return object
     */
    public function setAnonymousUuid(?string $anonymousUuid)
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
    public function getAnonymousUuid(): ?string
    {
        return $this->anonymousUuid;
    }

    # endregion

    /**
     * @var boolean
     */
    private $_anonymousUuid;
}
