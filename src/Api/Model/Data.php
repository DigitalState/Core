<?php

namespace Ds\Component\Api\Model;

use Ds\Component\Model\Attribute;

/**
 * Class Data
 *
 * @package Ds\Component\Api
 */
final class Data implements Model
{
    use Attribute\Id;
    use Attribute\Uuid;
}
