<?php

namespace Ds\Component\Api\Model\Services;

use Ds\Component\Api\Model\Attribute;
use Ds\Component\Api\Model\Model;

/**
 * Class Service
 *
 * @package Ds\Component\Api
 */
class Service implements Model
{
    use Attribute\Id;
    use Attribute\Uuid;
}
