<?php

namespace Ds\Component\Api\Model;

use Ds\Component\Model\Attribute;

/**
 * Class Asset
 *
 * @package Ds\Component\Api
 */
final class Asset implements Model
{
    use Attribute\Id;
    use Attribute\Uuid;
}
