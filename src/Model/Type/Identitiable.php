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
     * @return \Ds\Component\Model\Type\Identitiable
     */
    public function setIdentity(string $identity): Identitiable;

    /**
     * Get identity
     *
     * @return string
     */
    public function getIdentity(): ?string;

    /**
     * Set identity uuid
     *
     * @param string $identityUuid
     * @return \Ds\Component\Model\Type\Identitiable
     */
    public function setIdentityUuid(string $identityUuid): Identitiable;

    /**
     * Get identity uuid
     *
     * @return string
     */
    public function getIdentityUuid(): ?string;
}
