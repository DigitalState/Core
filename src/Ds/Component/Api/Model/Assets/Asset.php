<?php

namespace Ds\Component\Api\Model\Assets;

use Ds\Component\Api\Model\Attribute;
use Ds\Component\Api\Model\Model;

/**
 * Class Asset
 *
 * @package Ds\Component\Api
 */
class Asset implements Model
{
    use Attribute\Id;
    use Attribute\Uuid;
}
