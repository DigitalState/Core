<?php

namespace Ds\Component\Api\Model;

use Ds\Component\Model\Attribute;
use Ds\Component\Api\Model\Attribute as ApiAttribute;

/**
 * Class SystemRole
 *
 * @package Ds\Component\Api
 */
final class SystemRole implements Model
{
    use Attribute\Id;
    use Attribute\Uuid;
    use Attribute\CreatedAt;
    use Attribute\UpdatedAt;
    use Attribute\Owner;
    use Attribute\OwnerUuid;
    use ApiAttribute\System;
    use ApiAttribute\Role;
    use ApiAttribute\BusinessUnits;
    use Attribute\Version;
    use Attribute\Tenant;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->businessUnits = [];
        $this->version = 1;
    }
}
