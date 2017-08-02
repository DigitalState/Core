<?php

namespace Ds\Component\Identity;

/**
 * Interface Identity
 *
 * @package Ds\Component\Identity
 */
interface Identity
{
    /**
     * @const string
     */
    const ADMIN = 'Admin';
    const SYSTEM = 'System';
    const STAFF = 'Staff';
    const INDIVIDUAL = 'Individual';
    const ANONYMOUS = 'Anonymous';
}
