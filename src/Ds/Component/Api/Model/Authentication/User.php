<?php

namespace Ds\Component\Api\Model\Authentication;

use Ds\Component\Api\Model\Attribute;
use Ds\Component\Api\Model\Model;

/**
 * Class User
 *
 * @package Ds\Component\Api
 */
class User implements Model
{
    use Attribute\Id;
    use Attribute\Uuid;
}
