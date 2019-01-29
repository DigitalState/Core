<?php

namespace Ds\Component\Api\Model;

use Ds\Component\Model\Attribute;

/**
 * Class CaseModel
 *
 * @package Ds\Component\Api
 */
final class CaseModel implements Model
{
    use Attribute\Id;
    use Attribute\Uuid;
}
