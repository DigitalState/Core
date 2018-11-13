<?php

namespace Ds\Component\Api\Model;

use Ds\Component\Model\Attribute;

/**
 * Class StaffPersona
 *
 * @package Ds\Component\Api
 */
final class StaffPersona implements Model
{
    use Attribute\Id;
    use Attribute\Uuid;
    use Attribute\CreatedAt;
    use Attribute\UpdatedAt;
    use Attribute\Owner;
    use Attribute\OwnerUuid;
    use Attribute\Title;
    use Attribute\Data;
    use Attribute\Version;
}
