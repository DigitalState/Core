<?php

namespace Ds\Component\Api\Model;

use Ds\Component\Model\Attribute;
use Ds\Component\Api\Model\Attribute as ApiAttribute;

/**
 * Class OrganizationPersona
 *
 * @package Ds\Component\Api
 */
final class OrganizationPersona implements Model
{
    use Attribute\Id;
    use Attribute\Uuid;
    use Attribute\CreatedAt;
    use Attribute\UpdatedAt;
    use Attribute\Owner;
    use Attribute\OwnerUuid;
    use ApiAttribute\Organization;
    use Attribute\Title;
    use Attribute\Data;
    use Attribute\Version;
    use Attribute\Tenant;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->version = 1;
    }
}
