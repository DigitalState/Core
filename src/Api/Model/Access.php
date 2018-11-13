<?php

namespace Ds\Component\Api\Model;

use Ds\Component\Model\Attribute;
use Ds\Component\Api\Model\Attribute as ApiAttribute;

/**
 * Class Access
 *
 * @package Ds\Component\Api
 */
final class Access implements Model
{
    use Attribute\Id;
    use Attribute\Uuid;
    use Attribute\CreatedAt;
    use Attribute\UpdatedAt;
    use Attribute\Owner;
    use Attribute\OwnerUuid;
    use Attribute\Assignee;
    use Attribute\AssigneeUuid;
    use ApiAttribute\Permissions;
    use Attribute\Version;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->permissions = [];
    }
}
