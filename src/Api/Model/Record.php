<?php

namespace Ds\Component\Api\Model;

use Ds\Component\Model\Attribute;

/**
 * Class Record
 *
 * @package Ds\Component\Api
 */
final class Record implements Model
{
    use Attribute\Id;
    use Attribute\Uuid;
}
