<?php

namespace Ds\Component\Api\Model\Identities;

use Ds\Component\Api\Model\Attribute;
use Ds\Component\Api\Model\Model;

/**
 * Class Admin
 *
 * @package Ds\Component\Api
 */
class Admin implements Model
{
    use Attribute\Id;
    use Attribute\Uuid;
}
