<?php

namespace Ds\Component\Api\Model;

use Ds\Component\Model\Attribute;

/**
 * Class Individual
 *
 * @package Ds\Component\Api
 */
class Individual implements Model
{
    use Attribute\Id;
    use Attribute\Uuid;
    use Attribute\CreatedAt;
    use Attribute\UpdatedAt;
    use Attribute\Owner;
    use Attribute\OwnerUuid;
    use Attribute\Version;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->version = 1;
    }
}
