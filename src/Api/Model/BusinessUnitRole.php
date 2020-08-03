<?php

namespace Ds\Component\Api\Model;

use Ds\Component\Model\Attribute;
use Ds\Component\Api\Model\Attribute as ApiAttribute;

/**
 * Class BusinessUnitRole
 *
 * @package Ds\Component\Api
 */
final class BusinessUnitRole implements Model
{
    use Attribute\Id;
    use Attribute\Uuid;
    use Attribute\CreatedAt;
    use Attribute\UpdatedAt;
    use Attribute\Owner;
    use Attribute\OwnerUuid;
    use ApiAttribute\BusinessUnit;
    use ApiAttribute\Role;
    use Attribute\EntityUuids;
    use Attribute\Version;
    use Attribute\Tenant;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->entityUuids = [];
        $this->version = 1;
    }
}
