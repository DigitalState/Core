<?php

namespace Ds\Component\Api\Model\Identities;

use Ds\Component\Api\Model\Attribute;
use Ds\Component\Api\Model\Model;

/**
 * Class Staff
 *
 * @package Ds\Component\Api
 */
class Staff implements Model
{
    use Attribute\Id;
    use Attribute\Uuid;
}
