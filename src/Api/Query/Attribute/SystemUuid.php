<?php

namespace Ds\Component\Api\Query\Attribute;

/**
 * Trait SystemUuid
 *
 * @package Ds\Component\Api
 */
trait SystemUuid
{
    /**
     * @var string
     */
    private $systemUuid; # region accessors

    /**
     * Set system uuid
     *
     * @param string $systemUuid
     * @return object
     */
    public function setSystemUuid(?string $systemUuid)
    {
        $this->systemUuid = $systemUuid;
        $this->_systemUuid = true;

        return $this;
    }

    /**
     * Get system uuid
     *
     * @return string
     */
    public function getSystemUuid(): ?string
    {
        return $this->systemUuid;
    }

    # endregion

    /**
     * @var boolean
     */
    private $_systemUuid;
}
