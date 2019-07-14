<?php

namespace Ds\Component\Api\Model;

use Ds\Component\Model\Attribute;
use Ds\Component\Api\Model\Attribute as ApiAttribute;

/**
 * Class Permission
 *
 * @package Ds\Component\Api
 */
final class Permission implements Model
{
    use Attribute\Id;
    use Attribute\Uuid;
    use Attribute\CreatedAt;
    use Attribute\UpdatedAt;
    use ApiAttribute\Scope;
    use Attribute\Entity;
    use Attribute\EntityUuid;
    use Attribute\Key;
    use Attribute\Attributes;
    use Attribute\Version;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->attributes = [];
    }
}
