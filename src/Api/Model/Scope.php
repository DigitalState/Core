<?php

namespace Ds\Component\Api\Model;

use Ds\Component\Model\Attribute;
use Ds\Component\Api\Model\Attribute as ApiAttribute;

/**
 * Class Scope
 *
 * @package Ds\Component\Api
 */
final class Scope implements Model
{
    use Attribute\Type;
    use Attribute\Entity;
    use ApiAttribute\EntityUuid;
}
