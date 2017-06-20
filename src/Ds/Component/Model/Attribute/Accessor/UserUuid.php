<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait UserUuid
 */
trait UserUuid
{
    /**
     * Set user uuid
     *
     * @param string $userUuid
     * @return object
     */
    public function setUserUuid($userUuid)
    {
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
