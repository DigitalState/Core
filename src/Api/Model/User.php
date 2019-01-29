<?php

namespace Ds\Component\Api\Model;

use Ds\Component\Model\Attribute;

/**
 * Class User
 *
 * @package Ds\Component\Api
 */
final class User implements Model
{
    use Attribute\Id;
    use Attribute\Uuid;
    use Attribute\CreatedAt;
    use Attribute\UpdatedAt;
    use Attribute\Deleted;
    use Attribute\Username;
    use Attribute\Email;
    use Attribute\Enabled;
    use Attribute\LastLogin;
//    use Attribute\Groups;
//    use Attribute\Roles;
    use Attribute\Owner;
    use Attribute\OwnerUuid;
    use Attribute\Identity;
    use Attribute\IdentityUuid;
    use Attribute\Version;
}
