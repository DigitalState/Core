<?php

namespace Ds\Component\Security\Model;

/**
 * Class Identity
 *
 * @package Ds\Component\Security
 */
final class Identity
{
    /**
     * @const string
     */
    const SYSTEM = 'System';
    const STAFF = 'Staff';
    const ORGANIZATION = 'Organization';
    const INDIVIDUAL = 'Individual';
    const ANONYMOUS = 'Anonymous';

    use Attribute\Uuid;
    use Attribute\Type;
    use Attribute\Roles;
}
