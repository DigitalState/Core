<?php

namespace Ds\Component\Api\Model;

use Ds\Component\Model\Attribute;

/**
 * Class Anonymous
 *
 * @package Ds\Component\Api
 */
class Anonymous implements Model
{
    use Attribute\Id;
    use Attribute\Uuid;
}
