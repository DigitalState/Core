<?php

namespace Ds\Component\Model\Type;

/**
 * Interface Identitiable
 *
 * @package Ds\Component\Model
 */
interface Identitiable
{
    /**
     * Set identity
     *
     * @param string $identity
     * @return object
     */
    public function setIdentity($identity);

    /**
     * Get identity
     *
     * @return string
     */
    public function getIdentity();

    /**
     * Set identity uuid
     *
     * @param string $identityUuid
     * @return object
     */
    public function setIdentityUuid($identityUuid);

    /**
     * Get identity uuid
     *
     * @return string
     */
    public function getIdentityUuid();
}
