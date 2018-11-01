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
     */
    public function setIdentity(?string $identity);

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
     */
    public function setIdentityUuid(?string $identityUuid);

    /**
     * Get identity uuid
     *
     * @return string
     */
    public function getIdentityUuid(): ?string;
}
