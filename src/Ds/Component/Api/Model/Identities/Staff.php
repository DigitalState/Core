<?php

namespace Ds\Component\Api\Model\Identities;

use Ds\Component\Api\Model\Model;
use Ds\Component\Api\Model\Attribute;

/**
 * Class Staff
 */
class Staff implements Model
{
    use Attribute\Id;
    use Attribute\Uuid;
}
