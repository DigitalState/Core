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
    protected $systemUuid; # region accessors

    /**
     * Set system uuid
     *
     * @param string $systemUuid
     * @return \Ds\Component\Api\Query\Parameters
     */
    public function setSystemUuid($systemUuid)
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
    public function getSystemUuid()
    {
        return $this->systemUuid;
    }

    # endregion

    /**
     * @var boolean
     */
    protected $_systemUuid;
}
