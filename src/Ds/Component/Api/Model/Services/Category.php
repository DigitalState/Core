<?php

namespace Ds\Component\Api\Model\Services;

use Ds\Component\Api\Model\Attribute;
use Ds\Component\Api\Model\Model;

/**
 * Class Category
 *
 * @package Ds\Component\Api
 */
class Category implements Model
{
    use Attribute\Id;
    use Attribute\Uuid;
}
