<?php

namespace Ds\Component\Api\Model\Attribute\Accessor;

use Ds\Component\Api\Model\Staff as StaffModel;

/**
 * Trait Staff
 *
 * @package Ds\Component\Api
 */
trait Staff
{
    /**
     * Set staff
     *
     * @param \Ds\Component\Api\Model\Staff $staff
     * @return object
     */
    public function setStaff(?StaffModel $staff)
    {
        $this->staff = $staff;

        return $this;
    }

    /**
     * Get staff
     *
     * @return \Ds\Component\Api\Model\Staff
     */
    public function getStaff(): ?StaffModel
    {
        return $this->staff;
    }
}
