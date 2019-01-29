<?php

namespace Ds\Component\Api\Model;

use Ds\Component\Model\Attribute;

/**
 * Class Category
 *
 * @package Ds\Component\Api
 */
final class Category implements Model
{
    use Attribute\Id;
    use Attribute\Uuid;
}
