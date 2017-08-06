<?php

namespace Ds\Component\Api\Model\Records;

use Ds\Component\Api\Model\Attribute;
use Ds\Component\Api\Model\Model;

/**
 * Class Record
 *
 * @package Ds\Component\Api
 */
class Record implements Model
{
    use Attribute\Id;
    use Attribute\Uuid;
}
