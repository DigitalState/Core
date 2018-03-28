<?php

namespace Ds\Component\Api\Model;

use Ds\Component\Model\Attribute;
use Ds\Component\Api\Model\Attribute as ApiAttribute;

/**
 * Class IndividualPersona
 *
 * @package Ds\Component\Api
 */
class IndividualPersona implements Model
{
    use Attribute\Id;
    use Attribute\Uuid;
    use Attribute\CreatedAt;
    use Attribute\UpdatedAt;
    use Attribute\Owner;
    use Attribute\OwnerUuid;
    use ApiAttribute\Individual;
    use Attribute\Title;
    use Attribute\Data;
    use Attribute\Version;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->version = 1;
    }
}
