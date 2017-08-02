<?php

namespace Ds\Component\Api\Model\Identities;

use Ds\Component\Api\Model\Attribute;
use Ds\Component\Api\Model\Model;

/**
 * Class Individual
 *
 * @package Ds\Component\Api
 */
class Individual implements Model
{
    use Attribute\Id;
    use Attribute\Uuid;
}
