<?php

namespace Ds\Component\System\Model;

use Ds\Component\Model\Attribute;

/**
 * Class Tenant
 *
 * @package Ds\Component\System
 */
class Tenant implements Model
{
    use Attribute\Id;
    use Attribute\Uuid;
    use Attribute\CreatedAt;
    use Attribute\UpdatedAt;
    use Attribute\Data;
    use Attribute\Version;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->data = [];
        $this->version = 1;
    }
}
