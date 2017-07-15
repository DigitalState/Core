<?php

namespace Ds\Component\Translation\Model\Attribute;

use Ds\Component\Translation\Model\Attribute\Accessor;

/**
 * Trait Value
 */
trait Value
{
    use Accessor\Value;

    /**
     * @var array
     */
    protected $value;
}
