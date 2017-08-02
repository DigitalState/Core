<?php

namespace Ds\Component\Translation\Model\Attribute;

use Ds\Component\Translation\Model\Attribute\Accessor;

/**
 * Trait Title
 *
 * @package Ds\Component\Translation
 */
trait Title
{
    use Accessor\Title;

    /**
     * @var array
     */
    protected $title;
}
