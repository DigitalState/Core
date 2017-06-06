<?php

namespace Ds\Component\Api\Model\Identities;

use Ds\Component\Api\Model\Model;
use Ds\Component\Api\Model\Attribute;

/**
 * Class Individual
 */
class Individual implements Model
{
    use Attribute\Id;
    use Attribute\Uuid;
}
