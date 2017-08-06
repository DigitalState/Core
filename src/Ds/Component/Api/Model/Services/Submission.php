<?php

namespace Ds\Component\Api\Model\Services;

use Ds\Component\Api\Model\Attribute;
use Ds\Component\Api\Model\Model;

/**
 * Class Submission
 *
 * @package Ds\Component\Api
 */
class Submission implements Model
{
    use Attribute\Id;
    use Attribute\Uuid;
}
