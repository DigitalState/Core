<?php

namespace Ds\Component\Model\Attribute\Accessor;

use InvalidArgumentException;

/**
 * Trait UserUuid
 *
 * @package Ds\Component\Model
 */
trait UserUuid
{
    /**
     * Set user uuid
     *
     * @param string $userUuid
     * @return object
     * @throws \InvalidArgumentException
     */
    public function setUserUuid($userUuid)
    {
        if (null !== $userUuid) {
            if (!preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $userUuid)) {
                throw new InvalidArgumentException('Uuid is not valid.');
            }
        }

        $this->userUuid = $userUuid;

        return $this;
    }

    /**
     * Get user uuid
     *
     * @return string
     */
    public function getUserUuid()
    {
        return $this->userUuid;
    }
}
