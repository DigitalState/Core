<?php

namespace Ds\Component\Translation\Model\Attribute;

use Ds\Component\Translation\Model\Attribute\Accessor;

/**
 * Trait Data
 *
 * @package Ds\Component\Translation
 */
trait Data
{
    use Accessor\Data;

    /**
     * @var array
     */
    protected $data;
}
