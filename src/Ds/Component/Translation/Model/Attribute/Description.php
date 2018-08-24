<?php

namespace Ds\Component\Translation\Model\Attribute;

use Ds\Component\Translation\Model\Attribute\Accessor;

/**
 * Trait Description
 *
 * @package Ds\Component\Translation
 */
trait Description
{
    use Accessor\Description;

    /**
     * @var array
     */
    protected $description;
}
